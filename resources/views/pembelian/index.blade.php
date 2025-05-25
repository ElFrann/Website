@extends('layouts.app')

@section('title', 'Daftar Pembelian - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Pembelian</h1>

    <a href="{{ route('pembelian.create') }}" class="btn btn-primary mb-3">Tambah Pembelian</a>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($pembelian->count())
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th>ID Tanaman</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelian as $pembelian)
                        <tr>
                            <td>{{ $pembelian->jenis }}</td>
                            <td>{{ $pembelian->id_tanaman }}</td>
                            <td>{{ $pembelian->jumlah }}</td>
                            <td>{{ formatRupiah($pembelian->harga) }}</td>
                            <td>{{ $pembelian->tanggal }}</td>
                            <td>
                                <a href="{{ route('pembelian.show', $pembelian) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('pembelian.edit', $pembelian) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pembelian.destroy', $pembelian) }}" method="POST" style="display:inline-block;">
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
            <p>Tidak ada data pembelian.</p>
            @endif
        </div>
    </div>
</div>
@endsection
