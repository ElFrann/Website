@extends('layouts.app')

@section('title', 'Daftar Penjualan - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Penjualan</h1>

    <a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Tambah Penjualan</a>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($penjualans->count())
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Tanaman</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualans as $penjualan)
                        <tr>
                            <td>{{ $penjualan->id_tanaman }}</td>
                            <td>{{ $penjualan->jenis ?? '-' }}</td>
                            <td>{{ formatRupiah($penjualan->harga) }}</td>
                            <td>{{ $penjualan->tanggal }}</td>
                            <td>
                                <a href="{{ route('penjualan.show', $penjualan) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('penjualan.edit', $penjualan) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('penjualan.destroy', $penjualan) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p>Tidak ada data penjualan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
