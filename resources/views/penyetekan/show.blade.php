@extends('layouts.app')

@section('title', 'Hasil Penyetekan - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Hasil Penyetekan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>ID Tanaman Induk</h5>
            <p>{{ $id_tanaman }}</p>

            <h5>Jumlah Potongan</h5>
            <p>{{ $jumlah_potong }}</p>

            <h5>Hasil ID Tanaman Setelah Pemotongan</h5>
            <ul>
                @foreach($id_tanaman_potong as $id)
                    <li>{{ $id }}</li>
                @endforeach
            </ul>

            <a href="{{ route('penyetekan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
