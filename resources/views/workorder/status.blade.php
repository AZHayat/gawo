@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Status Work Order</h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nomor WO</th>
                <th>Status</th>
                <th>Nama Pemohon</th>
                <th>Departemen</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($workOrders as $wo)
            <tr>
                <td>{{ $wo->nomor_wo }}</td>
                <td>{{ $wo->status }}</td>
                <td>{{ $wo->nama_pemohon }}</td>
                <td>{{ $wo->departemen }}</td>
                <td>{{ $wo->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
