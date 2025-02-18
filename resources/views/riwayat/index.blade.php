@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Perubahan Sparepart</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pengguna</th>
                <th>Sparepart</th>
                <th>Aksi</th>
                <th>Perubahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayats as $riwayat)
                <tr>
                    <td>{{ $riwayat->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $riwayat->user->name }}</td>
                    <td>{{ $riwayat->sparepart->nama }}</td>
                    <td>{{ $riwayat->aksi }}</td>
                    <td>{{ $riwayat->perubahan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $riwayats->links() }}
</div>
@endsection
