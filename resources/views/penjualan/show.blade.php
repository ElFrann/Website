@extends('layouts.app')

@section('title', 'Detail Penjualan - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Penjualan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>ID Tanaman</h5>
            <p>{{ $penjualan->id_tanaman }}</p>

            <h5>Jenis</h5>
            <p>{{ $penjualan->jenis ?? '-' }}</p>

            <h5>Harga</h5>
            <p>{{ $penjualan->harga }}</p>

            <h5>Tanggal</h5>
            <p>{{ $penjualan->tanggal }}</p>

            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('penjualan.edit', $penjualan) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
