@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Service</h2>

    <a href="{{ route('service.create') }}" class="btn btn-primary mb-3">Tambah Service</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Plat Nomor</th>
                <th>Nama Customer</th>
                <th>Keluhan</th>
                <th>Sparepart</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Pegawai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->plat_nomor }}</td>
                <td>{{ $service->nama_customer }}</td>
                <td>{{ $service->keluhan }}</td>
                <td>
                    @foreach(json_decode($service->spareparts) as $sparepart)
                        <span class="badge bg-info">{{ $sparepart }}</span>
                    @endforeach
                </td>
                <td>Rp {{ number_format($service->total_harga, 2) }}</td>
                <td>{{ $service->status }}</td>
                <td>{{ $service->pegawai->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
