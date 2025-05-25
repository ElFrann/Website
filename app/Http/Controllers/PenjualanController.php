<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = Penjualan::all();
        return view('penjualan.index', compact('penjualans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil id_tanaman dari:
        // - Tanaman hasil stek (id_tanaman mengandung "-") atau
        // - Tanaman pembelian yang belum pernah di stek
        // dan belum pernah dijual
        $tanaman_tersedia = \App\Models\Tanaman::whereNotIn('id_tanaman', \App\Models\Penjualan::pluck('id_tanaman'))
            ->where(function($q) {
                $q->where('id_tanaman', 'like', '%-%')
                  ->orWhereNotIn('id_tanaman', \App\Models\Penyetekan::pluck('id_tanaman'));
            })
            ->get();
        return view('penjualan.create', compact('tanaman_tersedia'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_tanaman' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'harga' => 'nullable|numeric',
            'tanggal' => 'required|date',
        ]);

        \App\Models\Penjualan::create($validated);

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        return view('penjualan.edit', compact('penjualan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penjualan = Penjualan::findOrFail($id);

        $validated = $request->validate([
            'id_tanaman' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'harga' => 'nullable|numeric',
            'tanggal' => 'required|date',
        ]);

        $penjualan->update($validated);

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus.');
    }
}
