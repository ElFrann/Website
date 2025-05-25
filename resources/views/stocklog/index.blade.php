@extends('layouts.app')

@section('title', 'Stock Log - Inventory DiranPlant')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Stock Log</h1>
    <button class="btn btn-primary mb-3" onclick="window.print()">Print</button>
    <button class="btn btn-success mb-3" id="save-png-btn">Simpan PNG</button>

    <!-- Tabel log dan rekap -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Rekap Pemasukan/Pengeluaran</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>ID Tanaman</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->tanggal }}</td>
                        <td>{{ $log->jenis }}</td>
                        <td>{{ $log->id_tanaman }}</td>
                        <td>{{ $log->jumlah }}</td>
                        <td>{{ number_format($log->harga, 2, ',', '.') }}</td>
                        <td>{{ number_format($log->jumlah * $log->harga, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.getElementById('save-png-btn').onclick = function() {
    html2canvas(document.querySelector('.card')).then(function(canvas) {
        var link = document.createElement('a');
        link.download = 'stocklog.png';
        link.href = canvas.toDataURL();
        link.click();
    });
};
</script>
@endpush
@endsection