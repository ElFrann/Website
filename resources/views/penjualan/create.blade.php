@extends('layouts.app')

@section('title', 'Tambah Penjualan - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Penjualan</h1>

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_tanaman">ID Tanaman</label>
            <select name="id_tanaman" id="id_tanaman" class="form-control" required>
                <option value="">-- Pilih ID Tanaman --</option>
                @foreach($tanaman_tersedia as $tanaman)
                    <option value="{{ $tanaman->id_tanaman }}" {{ old('id_tanaman') == $tanaman->id_tanaman ? 'selected' : '' }}>
                        {{ $tanaman->id_tanaman }} ({{ $tanaman->jenis }})
                    </option>
                @endforeach
            </select>
            @error('id_tanaman')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="jenis">Jenis</label>
            <select name="jenis" id="jenis" class="form-control" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="monstera" {{ old('jenis') == 'monstera' ? 'selected' : '' }}>Monstera</option>
                <option value="philodendron" {{ old('jenis') == 'philodendron' ? 'selected' : '' }}>Philodendron</option>
                <option value="anthurium" {{ old('jenis') == 'anthurium' ? 'selected' : '' }}>Anthurium</option>
                <option value="platycerium" {{ old('jenis') == 'platycerium' ? 'selected' : '' }}>Platycerium</option>
                <option value="agave titanota" {{ old('jenis') == 'agave titanota' ? 'selected' : '' }}>Agave Titanota</option>
                <option value="kebutuhan" {{ old('jenis') == 'kebutuhan' ? 'selected' : '' }}>Kebutuhan</option>
            </select>
            @error('jenis')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" step="0.01" name="harga" id="harga" class="form-control" value="{{ old('harga') }}">
            @error('harga')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
            @error('tanggal')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
