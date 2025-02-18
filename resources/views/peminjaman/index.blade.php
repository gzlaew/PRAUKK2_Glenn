@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Peminjaman</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalPeminjaman">Tambah Peminjaman</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $item)
                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->barang->nama }}</td>
                    <td>{{ ucfirst($item->jenis_barang) }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->dikembalikan ? 'Sudah Dikembalikan' : 'Belum Dikembalikan' }}</td>
                    <td>
                        @if(!$item->dikembalikan)
                            <form action="{{ route('peminjaman.return', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                            </form>
                        @else
                            <span class="text-success">Selesai</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Peminjaman -->
<div class="modal fade" id="modalPeminjaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Jenis Barang</label>
                        <select name="jenis_barang" class="form-select" required>
                            <option value="alat">Alat</option>
                            <option value="sparepart">Sparepart</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Barang</label>
                        <select name="barang_id" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>

                            <optgroup label="Spareparts">
                                @foreach($spareparts as $item)
                                    <option value="sparepart_{{ $item->id_sparepart }}">
                                        {{ $item->nama }} (Stok: {{ $item->stok }})
                                    </option>
                                @endforeach
                            </optgroup>

                            <optgroup label="Alat">
                                @foreach($alats as $item)
                                    <option value="alat_{{ $item->id_alat }}">
                                        {{ $item->name }} (Stok: {{ $item->stok }})
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
