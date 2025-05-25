@extends('layouts.app')

@section('title', 'Penyetekan - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Penyetekan</h1>

    <a href="{{ route('penyetekan.create') }}" class="btn btn-primary mb-3">Tambah Penyetekan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($penyetekans->isEmpty())
                <p>Tidak ada data penyetekan.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Tanaman</th>
                            <th>Jenis</th>
                            <th>Jumlah Potong</th>
                            <th>Harga</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penyetekans as $penyetekan)
                        <tr>
                            <td>{{ $penyetekan->id_tanaman }}</td>
                            <td>{{ $penyetekan->jenis }}</td>
                            <td>{{ $penyetekan->jumlah_potong }}</td>
                            <td>{{ formatRupiah($penyetekan->harga) }}</td>
                            <td>{{ $penyetekan->tanggal }}</td>
                            <td>
                                <a href="{{ route('penyetekan.edit', $penyetekan) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('penyetekan.destroy', $penyetekan) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
