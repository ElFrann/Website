@extends('layouts.app')

@section('title', 'Tambah Pembelian - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Pembelian</h1>

    <form action="{{ route('pembelian.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
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
            <label for="id_tanaman">ID Tanaman</label>
            <input type="text" name="id_tanaman" id="id_tanaman" class="form-control" value="{{ old('id_tanaman') }}" required readonly>
            @error('id_tanaman')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah') }}" required>
            @error('jumlah')
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
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@push('scripts')
<script>
    // Data jumlah tanaman per jenis dari backend
    const jumlahPerJenis = @json($jumlahPerJenis ?? []);
    document.getElementById('jenis').addEventListener('change', function() {
        const jenis = this.value;
        let urutan = (jumlahPerJenis[jenis] ?? 0) + 1;
        if(jenis) {
            document.getElementById('id_tanaman').value = jenis + '-' + urutan;
        } else {
            document.getElementById('id_tanaman').value = '';
        }
    });
</script>
@endpush
@endsection
