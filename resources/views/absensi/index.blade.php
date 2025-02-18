@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Absensi Shift Kerja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>Shift Kerja</th>
                <th>Absen</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
@foreach($shifts as $shift)
<tr>
    <td>{{ $user->name }}</td>
    <td>
        {{ $shift->jamKerja->bagian }} ({{ $shift->jamKerja->jam_mulai }} - {{ $shift->jamKerja->jam_selesai }})
    </td>
    <td>
        @php
            $waktuMulai = \Carbon\Carbon::parse($shift->jamKerja->jam_mulai);
            $waktuSelesai = \Carbon\Carbon::parse($shift->jamKerja->jam_selesai);
            $now = \Carbon\Carbon::now();
        @endphp

        @if(in_array($shift->id, $absenHariIni))
            <span class="text-success">Sudah absen</span>
        @elseif($now->between($waktuMulai, $waktuSelesai))
            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                <button type="submit" class="btn btn-primary">Absen</button>
            </form>
        @elseif($now->lt($waktuMulai))
            <span class="text-info">Shift dimulai dalam <span data-timer="{{ $waktuMulai }}"></span></span>
        @else
            <span class="text-danger">Alpa</span>
        @endif
    </td>
    <td id="status-{{ $shift->id }}">
        @php
            $absensi = $shift->absensi ? $shift->absensi->where('user_id', $user->id)->first() : null;
        @endphp

        @if($absensi)
            {{ $absensi->status }}
        @elseif($now->gt($waktuSelesai))
            <span class="text-danger">Alpa</span>
        @else
            Belum absen
        @endif
    </td>
</tr>
@endforeach

        </tbody>
    </table>
</div>

<script>
function updateCountdown() {
    document.querySelectorAll("[data-timer]").forEach(function (el) {
        let shiftTime = new Date(el.getAttribute("data-timer")).getTime();
        let now = new Date().getTime();
        let diff = shiftTime - now;

        if (diff > 0) {
            let hours = Math.floor(diff / (1000 * 60 * 60));
            let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((diff % (1000 * 60)) / 1000);

            el.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
        } else {
            el.innerHTML = "Shift sedang berlangsung";
        }
    });
}

setInterval(updateCountdown, 1000);
updateCountdown();
</script>

@endsection
