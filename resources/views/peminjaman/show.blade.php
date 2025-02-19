@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Peminjaman</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Kode Peminjaman: {{ $peminjaman->kode_peminjaman }}</h5>
            <p class="card-text"><strong>Peminjam:</strong> {{ $peminjaman->user->name }}</p>
            <p class="card-text"><strong>Alat:</strong> {{ $peminjaman->alat->nama }}</p>
            <p class="card-text"><strong>Jumlah:</strong> {{ $peminjaman->jumlah }}</p>
            <p class="card-text"><strong>Tanggal Pengajuan:</strong> {{ $peminjaman->tanggal_pengajuan }}</p>
            <p class="card-text"><strong>Status:</strong>
                <span class="badge
                    @if($peminjaman->status == 'pengajuan') bg-warning
                    @elseif($peminjaman->status == 'dipinjam') bg-success
                    @elseif($peminjaman->status == 'dikembalikan') bg-primary
                    @elseif($peminjaman->status == 'ditolak') bg-danger
                    @endif">
                    {{ ucfirst($peminjaman->status) }}
                </span>
            </p>
            <p class="card-text"><strong>Keterangan:</strong> {{ $peminjaman->keterangan ?? 'Tidak ada' }}</p>

            @if($peminjaman->tanggal_kembali)
                <p class="card-text"><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_kembali }}</p>
            @endif


            @if(in_array(Auth::user()->role, ['admin','supervisor']))
    <div class="mt-3">
        @if($peminjaman->status == 'pengajuan')
            <form action="{{ route('peminjaman.approve', $peminjaman->id) }}" method="POST" class="d-inline">
                @csrf @method('PUT')
                <button type="submit" class="btn btn-success">Setujui</button>
            </form>

            <form action="{{ route('peminjaman.reject', $peminjaman->id) }}" method="POST" class="d-inline">
                @csrf @method('PUT')
                <button type="submit" class="btn btn-danger">Tolak</button>
            </form>
        @endif
        @endif

        @if($peminjaman->status == 'dipinjam')
            <form action="{{ route('peminjaman.kembali', $peminjaman->id) }}" method="POST" class="d-inline">
                @csrf @method('PUT')
                <button type="submit" class="btn btn-info">Kembalikan</button>
            </form>
        @endif

        <a href="{{ url('peminjaman') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
