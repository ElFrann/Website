@extends('layouts.app')

@section('title', 'Daftar Tanaman Hias - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Tanaman Hias</h1>
    <button class="btn btn-primary mb-3" onclick="window.print()">Print</button>
    <button class="btn btn-success mb-3" id="save-png-btn">Simpan PNG</button>

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
                        {{-- formatRupiah sudah ada di helpers, gunakan langsung --}}
                        @foreach($inventories as $item)
                        <tr>
                            <td>{{ $item->id_tanaman }}</td>
                            <td>{{ $item->jenis ?? '-' }}</td>
                            <td>
                                @if(isset($item->jumlah) && isset($item->harga))
                                    Pembelian
                                @else
                                    Tanaman
                                @endif
                            </td>
                            <td>{{ $item->jumlah ?? 1 }}</td>
                            <td>
                                @php
                                    $harga = $item->harga ?? null;
                                @endphp
                                {{ is_numeric($harga) ? formatRupiah((float)$harga) : '-' }}
                            </td>
                            <td>{{ $item->tanggal ?? ($item->created_at ?? '-') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.getElementById('save-png-btn').onclick = function() {
    html2canvas(document.querySelector('.card')).then(function(canvas) {
        var link = document.createElement('a');
        link.download = 'inventories.png';
        link.href = canvas.toDataURL();
        link.click();
    });
};
</script>
@endpush
