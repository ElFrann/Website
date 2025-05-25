<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Pembelian;
use App\Models\Penyetekan;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelian = \App\Models\Pembelian::all();
        $penyetekans = class_exists(\App\Models\Penyetekan::class) ? \App\Models\Penyetekan::all() : collect();
        $tanaman = class_exists(\App\Models\Tanaman::class) ? \App\Models\Tanaman::all() : collect();

        // Ambil semua id_tanaman yang sudah pernah di stek
        $id_tanaman_stek = $penyetekans->pluck('id_tanaman')->filter()->unique();

        // Tanaman hasil stek: id_tanaman mengandung "-"
        $tanaman_hasil_stek = $tanaman->filter(function($item) {
            return strpos($item->id_tanaman, '-') !== false;
        });

        // Tanaman pembelian yang belum pernah di stek: id_tanaman tidak ada di $id_tanaman_stek dan tidak mengandung "-"
        $tanaman_beli_belum_stek = $tanaman->filter(function($item) use ($id_tanaman_stek) {
            return !in_array($item->id_tanaman, $id_tanaman_stek->toArray()) && strpos($item->id_tanaman, '-') === false;
        });

        // Gabungkan hasil
        $inventories = $tanaman_hasil_stek->concat($tanaman_beli_belum_stek);

        // Pastikan harga bertipe float/null agar tidak error di number_format()
        $inventories->transform(function($item) {
            if (isset($item->harga)) {
                $item->harga = is_numeric($item->harga) ? (float)$item->harga : null;
            }
            return $item;
        });

        return view('inventories.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pembelian = Pembelian::all();
        $penyetekans = class_exists(\App\Models\Penyetekan::class) ? \App\Models\Penyetekan::all() : collect();
        $tanaman = class_exists(\App\Models\Tanaman::class) ? \App\Models\Tanaman::all() : collect();

        // Ambil semua id_penyetekan
        $penyetekanIds = $penyetekans->pluck('id_penyetekan')->filter()->unique();

        // Filter pembelian dan tanaman yang id_tanaman-nya belum pernah jadi id_penyetekan
        $filteredPembelian = $pembelian->filter(function($item) use ($penyetekanIds) {
            return !$penyetekanIds->contains($item->id_tanaman);
        });
        $filteredTanaman = $tanaman->filter(function($item) use ($penyetekanIds) {
            return !$penyetekanIds->contains($item->id_tanaman);
        });

        // Gabungkan data yang sudah difilter
        $inventories = $filteredPembelian->concat($penyetekans)->concat($filteredTanaman);

        return view('inventories.create', compact('inventories', 'pembelian', 'penyetekans', 'tanaman'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil data dari pembelian atau penyetekan sesuai id_tanaman
        $item = Pembelian::where('id_tanaman', $id)->first();
        $sumber = 'Pembelian';
        if (!$item && class_exists(\App\Models\Penyetekan::class)) {
            $item = \App\Models\Penyetekan::where('id_tanaman', $id)->first();
            $sumber = 'Penyetekan';
        }
        if (!$item) abort(404);

        $item->sumber = $sumber;
        return view('inventories.show', compact('item'));
    }
}
