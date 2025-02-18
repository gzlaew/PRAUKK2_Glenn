@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manajemen Jam Kerja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Jam Kerja</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bagian</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jamKerja as $jk)
            <tr>
                <td>{{ $jk->id_jk }}</td>
                <td>{{ ucfirst($jk->bagian) }}</td>
                <td>{{ $jk->jam_mulai }}</td>
                <td>{{ $jk->jam_selesai }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editData({{ $jk->id_jk }})">Edit</button>
                    <form action="{{ route('jamkerja.destroy', $jk->id_jk) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('jamkerja.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jam Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Bagian</label>
                    <select name="bagian" class="form-select">
                        <option value="pagi">Pagi</option>
                        <option value="siang">Siang</option>
                        <option value="malam">Malam</option>
                    </select>
                    <label>Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control">
                    <label>Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
