@extends('layouts.app')

@section('title', 'Detail Pembelian - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Pembelian</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Jenis</h5>
            <p>{{ $pembelian->jenis }}</p>

            <h5>ID Tanaman</h5>
            <p>{{ $pembelian->id_tanaman }}</p>

            <h5>Jumlah</h5>
            <p>{{ $pembelian->jumlah }}</p>

            <h5>Harga</h5>
            <p>{{ $pembelian->harga }}</p>

            <h5>Tanggal</h5>
            <p>{{ $pembelian->tanggal }}</p>

            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('pembelian.edit', $pembelian) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
