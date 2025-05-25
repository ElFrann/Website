@extends('layouts.app')

@section('title', 'Detail Tanaman Hias - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Tanaman Hias</h1>

    {{-- formatRupiah sudah ada di helpers, gunakan langsung --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>ID Tanaman</h5>
            <p>{{ $item->id_tanaman }}</p>

            <h5>Jenis</h5>
            <p>{{ $item->jenis ?? '-' }}</p>

            <h5>Sumber</h5>
            <p>{{ $item->sumber ?? '-' }}</p>

            <h5>Jumlah</h5>
            <p>{{ $item->jumlah ?? 1 }}</p>

            <h5>Harga</h5>
            <p>{{ formatRupiah($item->harga ?? '-') }}</p>

            <h5>Tanggal Masuk</h5>
            <p>{{ $item->tanggal ?? '-' }}</p>

            <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
