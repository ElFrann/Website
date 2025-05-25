@extends('layouts.app')

@section('title', 'Daftar Jenis Tanaman - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Jenis Tanaman</h1>

    <a href="{{ route('plant_types.create') }}" class="btn btn-primary mb-3">Tambah Jenis Tanaman</a>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($plantTypes->count())
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plantTypes as $plantType)
                        <tr>
                            <td>{{ $plantType->name }}</td>
                            <td>{{ $plantType->description }}</td>
                            <td>
                                <a href="{{ route('plant_types.show', $plantType) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('plant_types.edit', $plantType) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('plant_types.destroy', $plantType) }}" method="POST" style="display:inline-block;">
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
            <p>Tidak ada data jenis tanaman.</p>
            @endif
        </div>
    </div>
</div>
@endsection
