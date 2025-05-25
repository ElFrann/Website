@extends('layouts.app')

@section('title', 'Tambah Penyetekan - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Penyetekan</h1>

    <form action="{{ route('penyetekan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_tanaman">ID Tanaman Induk</label>
            <select class="form-control" id="id_tanaman" name="id_tanaman" required>
                <option value="">-- Pilih ID Tanaman --</option>
                @foreach($id_tanaman_tersedia as $id)
                    <option value="{{ $id }}" {{ old('id_tanaman') == $id ? 'selected' : '' }}>{{ $id }}</option>
                @endforeach
            </select>
            @error('id_tanaman')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="jenis">Jenis</label>
            <input type="text" class="form-control" id="jenis" name="jenis" value="{{ old('jenis') }}" required readonly>
            @error('jenis')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="jumlah_potong">Jumlah Potongan</label>
            <input type="number" class="form-control" id="jumlah_potong" name="jumlah_potong" min="2" max="26" value="{{ old('jumlah_potong', 2) }}" required>
            @error('jumlah_potong')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" step="0.01" class="form-control" id="harga" name="harga" value="{{ old('harga') }}">
            @error('harga')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            @error('tanggal')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('penyetekan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#id_tanaman').on('change', function () {
        const id = $(this).val();
        if (id) {
            $.ajax({
                url: `http://127.0.0.1:8000/get-jenis/${id}`,
                type: 'GET',
                success: function (data) {
                    $('#jenis').val(data.jenis);
                },
                error: function () {
                    $('#jenis').val('');
                    alert('Gagal mengambil data jenis.');
                }
            });
        } else {
            $('#jenis').val('');
        }
    });
</script>

@endsection

@push('scripts')
<script>
document.getElementById('id_tanaman').addEventListener('change', function() {
    var id = this.value;
    if (!id) {
        document.getElementById('jenis').value = '';
        return;
    }
    fetch('/api/tanaman/jenis/' + encodeURIComponent(id))
        .then(response => response.json())
        .then(data => {
            document.getElementById('jenis').value = data.jenis || '';
        })
        .catch(() => {
            document.getElementById('jenis').value = '';
        });
});
</script>
@endpush
