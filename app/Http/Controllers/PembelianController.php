<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelian = Pembelian::all();
        return view('pembelian.index', compact('pembelian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Kirim data jumlah per jenis ke view untuk JS, jika diperlukan
        $jumlahPerJenis = \App\Models\Pembelian::selectRaw('jenis, count(*) as jumlah')->groupBy('jenis')->pluck('jumlah', 'jenis');
        return view('pembelian.create', compact('jumlahPerJenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|min:3|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'nullable|numeric',
            'tanggal' => 'required|date',
        ], [
            'jenis.min' => 'Jenis tanaman minimal 3 huruf.',
            'jumlah.min' => 'Jumlah tanaman minimal 1.',
        ]);

        $jenis = strtoupper(substr($validated['jenis'], 0, 3));

        // Ambil counter terakhir dari database untuk jenis ini
        $lastTanaman = \App\Models\Pembelian::whereRaw('UPPER(LEFT(jenis,3)) = ?', [$jenis])
            ->orderByRaw("CAST(SUBSTRING(id_tanaman, 4, 3) AS INTEGER) DESC")
            ->first();

        $lastCounter = 0;
        if ($lastTanaman) {
            $lastCounter = (int)substr($lastTanaman->id_tanaman, 3, 3);
        }

        $createdTanaman = [];
        for ($i = 1; $i <= $validated['jumlah']; $i++) {
            $counter = $lastCounter + $i;
            $id_tanaman = $jenis . str_pad($counter, 3, '0', STR_PAD_LEFT);

            $data = $validated;
            $data['id_tanaman'] = $id_tanaman;
            $data['jumlah'] = 1; // Setiap entri satu tanaman

            \App\Models\Pembelian::create($data);
            $createdTanaman[] = $id_tanaman;
        }

        // Tampilkan output ID tanaman yang dibuat
        $output = "ID Tanaman yang dibuat:<br>";
        foreach ($createdTanaman as $idx => $id) {
            $output .= "Tanaman ke-" . ($idx+1) . ": " . $id . "<br>";
        }

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil ditambahkan.<br>'.$output);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        return view('pembelian.show', compact('pembelian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        return view('pembelian.edit', compact('pembelian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'id_tanaman' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'harga' => 'nullable|numeric',
            'tanggal' => 'required|date',
        ]);

        $pembelian->update($validated);

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil dihapus.');
    }
}
