@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Service</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('service.store') }}" method="POST">
        @csrf

        <!-- Plat Nomor -->
        <div class="mb-3">
            <label>Plat Nomor</label>
            <input type="text" name="plat_nomor" class="form-control" required
                   value="{{ old('plat_nomor') }}">
            @error('plat_nomor') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Nama Customer -->
        <div class="mb-3">
            <label>Nama Customer</label>
            <input type="text" name="nama_customer" class="form-control" required
                   value="{{ old('nama_customer') }}">
            @error('nama_customer') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Nomor HP -->
        <div class="mb-3">
            <label>Nomor HP</label>
            <input type="text" name="nomor_hp" class="form-control" required
                   placeholder="08XXXXXXXXXX"
                   value="{{ old('nomor_hp') }}">
            @error('nomor_hp') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Keluhan -->
        <div class="mb-3">
            <label>Keluhan</label>
            <textarea name="keluhan" class="form-control" required>{{ old('keluhan') }}</textarea>
            @error('keluhan') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Jenis Service -->
        <div class="mb-3">
            <label>Jenis Service</label>
            <select name="jenis_service" class="form-control" required>
                <option value="">-- Pilih Jenis Service --</option>
                <option value="service ringan"
                    {{ old('jenis_service')=='service ringan' ? 'selected':'' }}>
                    Service Ringan
                </option>
                <option value="service besar"
                    {{ old('jenis_service')=='service besar' ? 'selected':'' }}>
                    Service Besar
                </option>
            </select>
            @error('jenis_service') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Pilih Pegawai (opsional) -->
        @if(isset($pegawaiHadir) && $pegawaiHadir->count())
        <div class="mb-3">
            <label>Pilih Pegawai</label>
            <select name="user_id" class="form-control">
                <option value="">-- Pilih Pegawai --</option>
                @foreach($pegawaiHadir as $pegawai)
                    <option value="{{ $pegawai->id }}"
                        {{ old('user_id') == $pegawai->id ? 'selected':'' }}>
                        {{ $pegawai->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        @endif

        <!-- Pilih Sparepart -->
        <div class="mb-3">
            <h4>Pilih Sparepart dan Jumlah</h4>

            @foreach($spareparts as $sparepart)
            <div class="d-flex align-items-center gap-3 border p-2 mb-2">
                <!-- Tombol Decrement (-) -->
                <button type="button" class="btn btn-outline-secondary decrement">-</button>

                <!-- Input jumlah -->
                <input type="hidden" name="spareparts[{{ $sparepart->id_sparepart }}][id]"
                       value="{{ $sparepart->id_sparepart }}">
                <input type="number" name="spareparts[{{ $sparepart->id_sparepart }}][jumlah]"
                       class="form-control qty-input"
                       value="0" min="0" max="{{ $sparepart->stok }}"
                       style="width: 60px; text-align: center;">

                <!-- Tombol Increment (+) -->
                <button type="button" class="btn btn-outline-success increment">+</button>

                <!-- Nama sparepart -->
                <span class="ml-3">{{ $sparepart->nama }} (Stok: {{ $sparepart->stok }})</span>
            </div>
            @endforeach
        </div>

        <!-- Estimasi Selesai -->
        <div class="mb-3">
            <label>Estimasi Selesai</label>
          <input type="time" name="estimasi_selesai" class="form-control" required>
            @error('estimasi_selesai') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    $(".increment").click(function() {
        let parent = $(this).closest(".d-flex");
        let input = parent.find(".qty-input");
        let current = parseInt(input.val());
        let maxVal = parseInt(input.attr("max"));
        if (current < maxVal) {
            input.val(current + 1);
        }
    });

    $(".decrement").click(function() {
        let parent = $(this).closest(".d-flex");
        let input = parent.find(".qty-input");
        let current = parseInt(input.val());
        if (current > 0) {
            input.val(current - 1);
        }
    });
});
</script>
@endsection
