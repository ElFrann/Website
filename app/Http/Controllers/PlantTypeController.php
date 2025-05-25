<?php

namespace App\Http\Controllers;

use App\Models\PlantType;
use Illuminate\Http\Request;

class PlantTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plantTypes = PlantType::all();
        return view('plant_types.index', compact('plantTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plant_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        PlantType::create($validated);

        return redirect()->route('plant_types.index')->with('success', 'Jenis tanaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plantType = PlantType::findOrFail($id);
        return view('plant_types.show', compact('plantType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plantType = PlantType::findOrFail($id);
        return view('plant_types.edit', compact('plantType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plantType = PlantType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $plantType->update($validated);

        return redirect()->route('plant_types.index')->with('success', 'Jenis tanaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plantType = PlantType::findOrFail($id);
        $plantType->delete();

        return redirect()->route('plant_types.index')->with('success', 'Jenis tanaman berhasil dihapus.');
    }
}
