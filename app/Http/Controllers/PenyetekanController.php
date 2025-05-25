<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyetekan;
use App\Models\Tanaman;
use Illuminate\Support\Facades\DB;

class PenyetekanController extends Controller
{
    public function index()
    {
        $penyetekans = Penyetekan::all();
        return view('penyetekan.index', compact('penyetekans'));
    }

    public function create()
    {
        // Ambil id_tanaman dari pembelian (tanaman utuh)
        $id_tanaman_pembelian = \App\Models\Pembelian::pluck('id_tanaman')->toArray();

        // Ambil id_tanaman dari hasil stek yang masih bisa distek ulang (maksimal 3 level, belum lebih dari 26 potongan)
        $id_tanaman_stek = \App\Models\Tanaman::whereRaw("id_tanaman ~ '^[A-Z0-9]+[a-z]{1,2}$'")->pluck('id_tanaman')->toArray();

        // Gabungkan semua id_tanaman yang bisa jadi induk stek
        $id_tanaman_tersedia = array_merge($id_tanaman_pembelian, $id_tanaman_stek);

        return view('penyetekan.create', compact('id_tanaman_tersedia'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_tanaman' => [
                'required',
                'string',
                function($attribute, $value, $fail) {
                    $isPembelian = \App\Models\Pembelian::where('id_tanaman', $value)->exists();
                    $isStek = \App\Models\Tanaman::where('id_tanaman', $value)->exists();
                    if (!$isPembelian && !$isStek) {
                        $fail('ID tanaman tidak valid atau tidak ditemukan di data pembelian atau stek.');
                    }
                }
            ],
            'jumlah_potong' => 'required|integer|min:1|max:26',
            'harga' => 'nullable|numeric',
            'tanggal' => [
                'required',
                'date',
                function($attribute, $value, $fail) use ($request) {
                    $id_tanaman = $request->input('id_tanaman');
                    $pembelian = \App\Models\Pembelian::where('id_tanaman', $id_tanaman)->first();
                    if ($pembelian && $value < $pembelian->tanggal_pembelian) {
                        $fail('Tanggal penyetekan tidak boleh lebih awal dari tanggal pembelian induk.');
                    }
                }
            ],
        ], [
            'jumlah_potong.min' => 'Minimal 1 potongan.',
            'jumlah_potong.max' => 'Maksimal 26 potongan (a-z).'
        ]);

        // Ambil jenis tanaman dan sumber induk
        $pembelian = \App\Models\Pembelian::where('id_tanaman', $validated['id_tanaman'])->first();
        $tanaman_stek = \App\Models\Tanaman::where('id_tanaman', $validated['id_tanaman'])->first();

        if ($pembelian) {
            $jenis = $pembelian->jenis;
            $sumber_induk = 'Pembelian';
        } elseif ($tanaman_stek) {
            $jenis = $tanaman_stek->jenis;
            $sumber_induk = 'Stek';
        } else {
            $jenis = '';
            $sumber_induk = '-';
        }

        DB::beginTransaction();
        try {
            // Simpan data penyetekan utama
            $penyetekan = Penyetekan::create([
                'id_tanaman' => $validated['id_tanaman'],
                'jenis' => $jenis,
                'jumlah_potong' => $validated['jumlah_potong'],
                'harga' => $validated['harga'] ?? null,
                'tanggal' => $validated['tanggal'],
            ]);

            // Update status tanaman induk (misal: sudah distek)
            if ($tanaman_stek) {
                $tanaman_stek->status = 'sudah distek';
                $tanaman_stek->save();
            } elseif ($pembelian) {
                $tanaman_induk = \App\Models\Tanaman::where('id_tanaman', $pembelian->id_tanaman)->first();
                if ($tanaman_induk) {
                    $tanaman_induk->status = 'sudah distek';
                    $tanaman_induk->save();
                }
            }

            // Perbaiki logika generate suffix agar tidak infinite loop jika sudah penuh
            $existing_suffixes = \App\Models\Tanaman::where('id_tanaman', 'like', $penyetekan->id_tanaman . '%')
                ->pluck('id_tanaman')
                ->map(function($id) use ($penyetekan) {
                    return substr($id, strlen($penyetekan->id_tanaman));
                })
                ->filter(function($suffix) {
                    return preg_match('/^[a-z]{1,2}$/', $suffix);
                })
                ->toArray();

            $used_indexes = [];
            foreach ($existing_suffixes as $suffix) {
                // Mendukung satu atau dua huruf (a-z, aa, ab, dst)
                $index = 0;
                if (strlen($suffix) == 1) {
                    $index = ord($suffix) - 97;
                } elseif (strlen($suffix) == 2) {
                    $index = (ord($suffix[0]) - 97 + 1) * 26 + (ord($suffix[1]) - 97);
                }
                $used_indexes[] = $index;
            }

            $anakan_ids = [];
            $count = 0;
            $i = 0;
            $max_suffix = 26 + 26*26; // batas maksimal kombinasi a-z + aa-zz (jika ingin lebih, sesuaikan)
            while ($count < $penyetekan->jumlah_potong && $i < $max_suffix) {
                if ($i < 26) {
                    $suffix = chr(97 + $i);
                } else {
                    $first = chr(97 + intval(($i - 26) / 26));
                    $second = chr(97 + (($i - 26) % 26));
                    $suffix = $first . $second;
                }
                if (!in_array($i, $used_indexes)) {
                    $id_anakan = $penyetekan->id_tanaman . $suffix;
                    if (!\App\Models\Tanaman::where('id_tanaman', $id_anakan)->exists()) {
                        $jenis_anakan = $jenis ?: 'Tidak diketahui';
                        \App\Models\Tanaman::create([
                            'id_tanaman' => $id_anakan,
                            'jenis' => $jenis_anakan,
                            // tambahkan field lain jika ada di tabel tanaman
                        ]);
                        $anakan_ids[] = $id_anakan;
                        $count++;
                    }
                }
                $i++;
            }

            // Jika jumlah stek yang berhasil dibuat kurang dari permintaan, rollback dan tampilkan error
            if ($count < $penyetekan->jumlah_potong) {
                DB::rollBack();
                return redirect()->back()->withInput()->withErrors([
                    'error' => 'Jumlah stek yang bisa dibuat tidak mencukupi permintaan. Mungkin sudah mencapai batas kombinasi suffix.'
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }

        $hasil_stek = [];
        foreach ($anakan_ids as $id) {
            $hasil_stek[] = [
                'id_stek' => $id,
                'jenis' => $jenis,
                'induk' => $penyetekan->id_tanaman,
                'sumber_induk' => $sumber_induk,
                'tanggal_stek' => $penyetekan->tanggal,
            ];
        }

        return view('penyetekan.hasil', [
            'hasil_stek' => $hasil_stek,
            'penyetekan' => $penyetekan,
            'success' => 'Data penyetekan & hasil stek berhasil ditambahkan.'
        ]);
    }

    public function show(Penyetekan $penyetekan)
    {
        // Ambil id anakan dari hasil stek (id_tanaman induk + a-z)
        $anakan_ids = [];
        for ($i = 0; $i < $penyetekan->jumlah_potong; $i++) {
            $suffix = chr(97 + $i);
            $anakan_ids[] = $penyetekan->id_tanaman . $suffix;
        }
        $tanaman_stek = Tanaman::whereIn('id_tanaman', $anakan_ids)->get();

        return view('penyetekan.show', [
            'penyetekan' => $penyetekan,
            'anakan_ids' => $anakan_ids,
            'tanaman_stek' => $tanaman_stek
        ]);
    }

    public function edit(Penyetekan $penyetekan)
    {
        return view('penyetekan.edit', compact('penyetekan'));
    }

    public function update(Request $request, Penyetekan $penyetekan)
    {
        $validated = $request->validate([
            'id_tanaman' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'jumlah_potong' => 'required|integer|min:1',
            'harga' => 'nullable|numeric',
            'tanggal' => 'required|date',
        ]);

        $penyetekan->update($validated);

        return redirect()->route('penyetekan.index')->with('success', 'Data penyetekan berhasil diperbarui.');
    }

    public function destroy(Penyetekan $penyetekan)
    {
        $penyetekan->delete();

        return redirect()->route('penyetekan.index')->with('success', 'Data penyetekan berhasil dihapus.');
    }
}
