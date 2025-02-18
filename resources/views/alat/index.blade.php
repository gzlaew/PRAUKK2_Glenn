@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manajemen Alat</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Alat</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Keterangan</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alat as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" width="50" alt="Gambar">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editAlat({{ $item->id_alat }})">Edit</button>
                        <form action="{{ route('alat.destroy', $item->id_alat) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('alat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Alat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Alat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id_alat">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <input type="text" id="edit_keterangan" name="keterangan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" id="edit_stok" name="stok" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editAlat(id) {
    fetch('/alat/' + id + '/edit')
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = data.id_alat;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_keterangan').value = data.keterangan;
            document.getElementById('edit_stok').value = data.stok;

            // Set action form agar mengarah ke URL update
            document.getElementById('editForm').action = '/alat/' + id;

            let modalEdit = new bootstrap.Modal(document.getElementById("modalEdit"));
            modalEdit.show();
        })
        .catch(error => console.error('Error fetching alat data:', error));
}
</script>
@endsection
