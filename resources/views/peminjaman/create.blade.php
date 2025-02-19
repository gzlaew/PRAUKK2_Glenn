@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Peminjaman</h1>
    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="kode_peminjaman" class="form-label">Kode Peminjaman</label>
            <input type="text" name="kode_peminjaman" class="form-control" value="{{ $kodePeminjaman }}" readonly>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">Peminjam</label>
            <select name="user_id" class="form-control" required>
                <option value="">Pilih Peminjam</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="alat_id" class="form-label">Pilih Alat</label>
            <select name="alat_id" class="form-control" required>
                <option value="">Pilih Alat</option>
                @foreach($alat as $a)
                    <option value="{{ $a->id }}">{{ $a->name }} (Stok: {{ $a->stok }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 row">
            <label for="jumlah" class="col-sm-2 col-form-label">jumlah</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" min='1' name='jumlah' id="jumlah">
            </div>
        </div>
        <div class="mb-3">
            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
            <input type="date" name="tanggal_pengajuan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
