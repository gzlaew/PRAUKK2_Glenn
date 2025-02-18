@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Service</h2>

    <form action="{{ route('service.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Plat Nomor</label>
            <input type="text" name="plat_nomor" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nama Customer</label>
            <input type="text" name="nama_customer" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nomor HP</label>
            <input type="text" name="nomor_hp" class="form-control" required placeholder="08XXXXXXXXXX">
        </div>

        <div class="mb-3">
            <label>Keluhan</label>
            <textarea name="keluhan" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Pilih Sparepart</label>
            <select name="spareparts[]" class="form-control" multiple required>
                @foreach($spareparts as $sparepart)
                    <option value="{{ $sparepart->id_sparepart }}">{{ $sparepart->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Pilih Pegawai</label>
            <select name="user_id" class="form-control" required>
                @foreach($pegawaiHadir as $pegawai)
                    <option value="{{ $pegawai->id }}">{{ $pegawai->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Estimasi Selesai</label>
            <input type="text" name="estimasi_selesai" class="form-control" required placeholder="Contoh: 3 hari, 5 jam, dll">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
