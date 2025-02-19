@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Peminjaman</h1>
    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="kode_peminjaman" class="form-label">Kode Peminjaman</label>
            <input type="text" name="kode_peminjaman" class="form-control" value="{{ $peminjaman->kode_peminjaman }}" readonly>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">Peminjam</label>
            <input type="text" class="form-control" value="{{ $peminjaman->user->name }}" readonly>
        </div>
        <div class="mb-3">
            <label for="alat_id" class="form-label">Alat</label>
            <input type="text" class="form-control" value="{{ $peminjaman->alat->nama }}" readonly>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="text" class="form-control" value="{{ $peminjaman->jumlah }}" readonly>
        </div>
        <div class="mb-3">
            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
            <input type="text" class="form-control" value="{{ $peminjaman->tanggal_pengajuan }}" readonly>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="pengajuan" {{ $peminjaman->status == 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                <option value="diterima" {{ $peminjaman->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ $peminjaman->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
