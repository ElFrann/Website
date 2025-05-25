@extends('layouts.app')

@section('title', 'Edit Pembelian - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Pembelian</h1>

    <form action="{{ route('pembelian.update', $pembelian) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="jenis">Jenis</label>
            <select name="jenis" id="jenis" class="form-control" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="monstera" {{ old('jenis', $pembelian->jenis) == 'monstera' ? 'selected' : '' }}>Monstera</option>
                <option value="philodendron" {{ old('jenis', $pembelian->jenis) == 'philodendron' ? 'selected' : '' }}>Philodendron</option>
                <option value="anthurium" {{ old('jenis', $pembelian->jenis) == 'anthurium' ? 'selected' : '' }}>Anthurium</option>
                <option value="platycerium" {{ old('jenis', $pembelian->jenis) == 'platycerium' ? 'selected' : '' }}>Platycerium</option>
                <option value="agave titanota" {{ old('jenis', $pembelian->jenis) == 'agave titanota' ? 'selected' : '' }}>Agave Titanota</option>
                <option value="kebutuhan" {{ old('jenis', $pembelian->jenis) == 'kebutuhan' ? 'selected' : '' }}>Kebutuhan</option>
            </select>
            @error('jenis')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_tanaman">ID Tanaman</label>
            <input type="text" name="id_tanaman" id="id_tanaman" class="form-control" value="{{ old('id_tanaman', $pembelian->id_tanaman) }}" required readonly>
            @error('id_tanaman')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah', $pembelian->jumlah) }}" required>
            @error('jumlah')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" step="0.01" name="harga" id="harga" class="form-control" value="{{ old('harga', $pembelian->harga) }}">
            @error('harga')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $pembelian->tanggal) }}" required>
            @error('tanggal')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@push('scripts')
<script>
    const inisialJenis = {
        'monstera': 'M',
        'philodendron': 'P',
        'anthurium': 'A',
        'platycerium': 'PL',
        'agave titanota': 'AT'
    };

    document.addEventListener('DOMContentLoaded', function() {
        const jenisSelect = document.getElementById('jenis');
        const idTanamanInput = document.getElementById('id_tanaman');
        const currentIdTanaman = idTanamanInput.value;

        function fetchNextId(jenis) {
            fetch(`/pembelian/next-id/${jenis}`)
                .then(response => response.json())
                .then(data => {
                    if (data.next_id) {
                        idTanamanInput.value = data.next_id;
                    } else {
                        idTanamanInput.value = '';
                    }
                });
        }

        function handleJenisChange() {
            const jenis = jenisSelect.value;
            if (jenis === 'kebutuhan' || !jenis) {
                idTanamanInput.readOnly = false;
                idTanamanInput.value = currentIdTanaman;
            } else {
                idTanamanInput.readOnly = true;
                fetchNextId(jenis);
            }
        }

        jenisSelect.addEventListener('change', handleJenisChange);

        // Trigger on page load
        handleJenisChange();
    });
</script>
@endpush
@endsection
