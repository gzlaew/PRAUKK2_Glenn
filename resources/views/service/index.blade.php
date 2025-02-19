@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Service</h2>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('service.create') }}" class="btn btn-primary mb-3">Tambah Service</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Plat Nomor</th>
                <th>Nama Customer</th>
                <th>Nomor HP</th>
                <th>Keluhan</th>
                <th>Sparepart</th>
                <th>Total Harga</th>
                <th>Status (Countdown)</th>
                <th>Pegawai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->plat_nomor }}</td>
                <td>{{ $service->nama_customer }}</td>
                <td>{{ $service->nomor_hp }}</td>
                <td>{{ $service->keluhan }}</td>
                <td>
                    @php
                      $spareparts = $service->spareparts;
                    @endphp
                    @if(is_array($spareparts))
                        @foreach($spareparts as $sp)
                          - {{ $sp['nama'] ?? 'Tidak ditemukan' }}
                            ({{ $sp['jumlah'] ?? 0 }} pcs)
                            - Rp{{ number_format($sp['harga'] ?? 0, 0, ',', '.') }}<br>
                        @endforeach
                    @else
                        <span class="text-danger">Data sparepart tidak valid</span>
                    @endif
                </td>
                <td>Rp {{ number_format($service->total_harga, 0, ',', '.') }}</td>

                <!-- Kolom Countdown -->
                <td>
                    <span class="js-countdown"
                          data-estimasi="{{ $service->estimasi_selesai }}"
                          data-dbstatus="{{ $service->status }}">
                        {{ $service->status }}
                    </span>
                </td>

                <td>{{ optional($service->pegawai)->name ?? 'N/A' }}</td>

                <td>
                    <form action="{{ route('service.destroy', $service->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus service ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function updateCountdown() {
    document.querySelectorAll(".js-countdown").forEach(el => {
        const estimasi = el.getAttribute("data-estimasi");
        const dbStatus = el.getAttribute("data-dbstatus") || "Proses";
        if (!estimasi) return;

        // Misal estimasi = "08:30"
        let [hh, mm] = estimasi.split(":");
        if (!hh || !mm) {
            el.textContent = dbStatus + " (Format estimasi invalid)";
            return;
        }

        let now = new Date();            // Waktu sekarang
        let estimasiTime = new Date();   // Mulai dari "hari ini"

        // Set jam & menit
        estimasiTime.setHours(hh, mm, 0, 0);

        // Jika estimasiTime <= sekarang, artinya jam-nya sudah lewat hari ini
        // -> kita anggap estimasi besok (tambah 1 hari)
        if (estimasiTime <= now) {
            estimasiTime.setDate(estimasiTime.getDate() + 1);
        }

        let diff = estimasiTime - now; // milidetik selisih

        if (diff <= 0) {
            // Sudah melewati (atau sama) => "Selesai"
            el.textContent = "Selesai";
            el.classList.add("text-success");
        } else {
            // Hitung sisa jam, menit, detik
            let h = Math.floor(diff / (1000 * 60 * 60));
            let m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            let s = Math.floor((diff % (1000 * 60)) / 1000);

            el.textContent = `${dbStatus} (Sisa: ${h}h ${m}m ${s}s)`;
            el.classList.remove("text-success");
        }
    });
}

</script>
@endsection
