@extends('layouts.app')

@section('title', 'Detail Jenis Tanaman - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Jenis Tanaman</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Nama: {{ $plantType->name }}</h5>
            <p>Deskripsi: {{ $plantType->description }}</p>
            <a href="{{ route('plant_types.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('plant_types.edit', $plantType) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
