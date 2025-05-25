@extends('layouts.app')

@section('title', 'Rekap Keluar Masuk Barang - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Rekap Keluar Masuk Barang</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($pembelians->count() || $penjualans->count())
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>ID Tanaman</th>
                            <th>Jenis</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data masuk dari pembelian --}}
                        @foreach($pembelians as $item)
                        <tr>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->id_tanaman }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>Masuk</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->harga }}</td>
                        </tr>
                        @endforeach
                        {{-- Data keluar dari penjualan --}}
                        @foreach($penjualans as $item)
                        <tr>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->id_tanaman }}</td>
                            <td>-</td>
                            <td>Keluar</td>
                            <td>1</td>
                            <td>{{ $item->harga }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p>Tidak ada data rekap keluar masuk barang.</p>
            @endif
        </div>
    </div>
</div>
@endsection
