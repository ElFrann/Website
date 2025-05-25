@extends('layouts.app')

@section('title', 'Daftar Tanaman Hias - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Tanaman Hias</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Tanaman</th>
                            <th>Jenis</th>
                            <th>Sumber</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Tanggal Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data dari pembelian --}}
                        {{-- formatRupiah sudah ada di helpers, gunakan langsung --}}
                        @foreach($pembelians as $item)
                        <tr>
                            <td>{{ $item->id_tanaman }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>Pembelian</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ formatRupiah($item->harga) }}</td>
                            <td>{{ $item->tanggal }}</td>
                        </tr>
                        @endforeach
                        {{-- Data dari penyetekan --}}
                        @foreach($penyetekan as $item)
                        <tr>
                            <td>{{ $item->id_tanaman }}</td>
                            <td>{{ $item->jenis ?? '-' }}</td>
                            <td>Penyetekan</td>
                            <td>1</td>
                            <td>-</td>
                            <td>{{ $item->tanggal ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
