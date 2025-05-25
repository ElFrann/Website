@extends('layouts.app')

@section('title', 'Edit Penyetekan - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Penyetekan</h1>

    <form action="{{ route('penyetekan.update', $penyetekan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_tanaman">ID Tanaman Induk</label>
            <input type="text" class="form-control" id="id_tanaman" name="id_tanaman" value="{{ old('id_tanaman', $penyetekan->id_tanaman) }}" required pattern="[A-Z]{3}[0-9]{3}" readonly>
            @error('id_tanaman')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="jenis">Jenis</label>
            <input type="text" class="form-control" id="jenis" name="jenis" value="{{ old('jenis', $penyetekan->jenis) }}" required readonly>
            @error('jenis')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="jumlah_potong">Jumlah Potongan</label>
            <input type="number" class="form-control" id="jumlah_potong" name="jumlah_potong" min="2" max="26" value="{{ old('jumlah_potong', $penyetekan->jumlah_potong) }}" required>
            @error('jumlah_potong')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" step="0.01" class="form-control" id="harga" name="harga" value="{{ old('harga', $penyetekan->harga) }}">
            @error('harga')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $penyetekan->tanggal) }}" required>
            @error('tanggal')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('penyetekan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
