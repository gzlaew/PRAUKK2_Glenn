@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manajemen Sparepart</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah Sparepart -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalSparepart" onclick="openModal()">Tambah Sparepart</button>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahStok">Tambah Stok</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Stok</th>
                <th>Harga (Per Pcs)</th>
                <th>Total Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($spareparts as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>Rp {{ number_format($item->harga, 2) }}</td>
                    <td><strong>Rp {{ number_format($item->stok * $item->harga, 2) }}</strong></td>
                    <td>
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" width="50">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editSparepart({{ $item->id_sparepart }})">Edit</button>
                        <form action="{{ route('sparepart.destroy', $item->id_sparepart) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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

<div class="modal fade" id="modalTambahStok" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('sparepart.addStock') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Stok Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Pilih Sparepart</label>
                        <select name="id_sparepart" class="form-select" required>
                            <option value="">-- Pilih Sparepart --</option>
                            @foreach($spareparts as $item)
                                <option value="{{ $item->id_sparepart }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Jumlah Stok Baru</label>
                        <input type="number" name="stok" class="form-control" required min="1">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tambah Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="modalSparepart" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="sparepartForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="sparepart_id" name="id_sparepart">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" id="sparepart_nama" name="nama" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" id="sparepart_stok" name="stok" class="form-control" required oninput="updateTotalHarga()">
                    </div>

                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" id="sparepart_harga" name="harga" class="form-control" required oninput="updateTotalHarga()">
                    </div>

                    <div class="mb-3">
                        <label>Total Harga</label>
                        <input type="text" id="sparepart_total_harga" class="form-control" disabled>
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
// ✅ Fungsi untuk membuka modal dengan mode "Tambah Sparepart"
function openModal() {
    document.getElementById('modalTitle').innerText = "Tambah Sparepart";
    document.getElementById('sparepartForm').setAttribute('action', "{{ route('sparepart.store') }}");
    document.getElementById('sparepartForm').reset();
    document.getElementById('sparepart_id').value = '';
    document.getElementById('sparepart_total_harga').value = 'Rp 0';
    $('#modalSparepart').modal('show');
}

// ✅ Fungsi untuk Edit Sparepart
function editSparepart(id) {
    fetch('/sparepart/' + id + '/edit')
        .then(response => response.json())
        .then(data => {
            document.getElementById('sparepartForm').setAttribute('action', '/sparepart/' + id);
            document.getElementById('sparepartForm').insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');

            document.getElementById('modalTitle').innerText = "Edit Sparepart";
            document.getElementById('sparepart_id').value = data.id_sparepart;
            document.getElementById('sparepart_nama').value = data.nama;
            document.getElementById('sparepart_stok').value = data.stok;
            document.getElementById('sparepart_harga').value = data.harga;

            // Hitung total harga saat modal terbuka
            let totalHarga = data.stok * data.harga;
            document.getElementById('sparepart_total_harga').value = formatRupiah(totalHarga);

            $('#modalSparepart').modal('show');
        });
}

// ✅ Fungsi untuk menghitung total harga secara real-time
function updateTotalHarga() {
    let stok = document.getElementById('sparepart_stok').value || 0;
    let harga = document.getElementById('sparepart_harga').value || 0;
    let totalHarga = stok * harga;
    document.getElementById('sparepart_total_harga').value = formatRupiah(totalHarga);
}

// ✅ Fungsi untuk format angka ke Rupiah
function formatRupiah(angka) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
}
</script>

@endsection
