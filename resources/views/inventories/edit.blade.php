@extends('layouts.app')

@section('title', 'Edit Tanaman Hias - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Tanaman Hias</h1>

    <form action="{{ route('inventories.update', $inventory) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $inventory->name) }}" required>
            @error('name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $inventory->description) }}</textarea>
            @error('description')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="quantity">Jumlah</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $inventory->quantity) }}" required>
            @error('quantity')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $inventory->location) }}">
            @error('location')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $inventory->price) }}">
            <small class="form-text text-muted">
                {{ formatRupiah(old('price', $inventory->price)) }}
            </small>
            @error('price')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
