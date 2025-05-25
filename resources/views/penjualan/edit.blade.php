@extends('layouts.app')

@section('title', 'Edit Penjualan - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Penjualan</h1>

    <form action="{{ route('penjualan.update', $penjualan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="id_tanaman">ID Tanaman</label>
            <input type="text" name="id_tanaman" id="id_tanaman" class="form-control" value="{{ old('id_tanaman', $penjualan->id_tanaman) }}" required>
            @error('id_tanaman')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="jenis">Jenis</label>
            <input type="text" name="jenis" id="jenis" class="form-control" value="{{ old('jenis', $penjualan->jenis) }}" required>
            @error('jenis')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" step="0.01" name="harga" id="harga" class="form-control" value="{{ old('harga', $penjualan->harga) }}">
            @error('harga')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $penjualan->tanggal) }}" required>
            @error('tanggal')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
