@extends('layouts.app')

@section('title', 'Tambah Jenis Tanaman - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Jenis Tanaman</h1>

    <form action="{{ route('plant_types.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Jenis Tanaman</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('plant_types.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
