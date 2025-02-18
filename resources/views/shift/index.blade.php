@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Jadwal Shift Kerja Karyawan</h2>

    {{-- Tampilkan pesan sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        $loggedInUser = auth()->user();
    @endphp

    {{-- Tombol "Tambah Shift" besar (hanya terlihat oleh Admin/Supervisor) --}}
    @if($loggedInUser && ($loggedInUser->role === 'Admin' || $loggedInUser->role === 'Supervisor'))
        <button type="button"
                class="btn btn-primary mb-4"
                data-bs-toggle="modal"
                data-bs-target="#tambahShiftModal"
                onclick="clearShiftDate()">
            Tambah Shift
        </button>
    @endif

    @php
        // Nama-nama bulan
        $namaBulan = [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];
    @endphp

    {{-- Navigasi Bulan Sebelumnya / Berikutnya --}}
    <div class="d-flex justify-content-between mb-3">
        <a class="btn btn-secondary"
           href="{{ route('shift.index', ['month' => $prevMonth, 'year' => $prevYear]) }}">
            &laquo; Bulan Sebelumnya
        </a>
        <h4 class="text-center mt-1">
            {{ $namaBulan[$month - 1] }} {{ $year }}
        </h4>
        <a class="btn btn-secondary"
           href="{{ route('shift.index', ['month' => $nextMonth, 'year' => $nextYear]) }}">
            Bulan Berikutnya &raquo;
        </a>
    </div>

    {{-- KALENDER --}}
    <div class="card p-3">
        <table class="table table-bordered text-center mb-0">
            <thead>
                <tr class="bg-light">
                    <th class="text-danger">Minggu</th>
                    <th>Senin</th>
                    <th>Selasa</th>
                    <th>Rabu</th>
                    <th>Kamis</th>
                    <th>Jumat</th>
                    <th>Sabtu</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hari = 1;
                @endphp
                <tr>
                    {{-- Kosongkan sel sebelum tanggal 1 --}}
                    @for($i = 0; $i < $startDay; $i++)
                        <td></td>
                    @endfor

                    {{-- Tampilkan tanggal 1 s/d $daysInMonth --}}
                    @for($i = $startDay; $i < 42; $i++)
                        @if($hari > $daysInMonth)
                            @break
                        @endif

                        <td class="clickable calendar-day
                            {{ $i % 7 == 0 ? 'text-danger' : '' }}"
                            data-day="{{ $hari }}">
                            <strong>{{ $hari }}</strong>
                        </td>

                        @if(($i + 1) % 7 == 0)
                            </tr><tr>
                        @endif

                        @php
                            $hari++;
                        @endphp
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>

    {{-- TABEL SHIFT --}}
    <div class="mt-4">
        <h4>Data Shift Tanggal <span id="selected-date">Pilih Tanggal</span></h4>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Pegawai</th>
                    <th>Shift Kerja</th>
                    @if(auth()->check() && (auth()->user()->role === 'Admin' || auth()->user()->role === 'Supervisor'))
                        <th>Opsi</th>
                    @endif
                </tr>
            </thead>
            <tbody id="shift-data">
                <tr>
                    <td colspan="3" class="text-center">
                        Pilih tanggal untuk melihat data shift.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH SHIFT --}}
@if($loggedInUser && ($loggedInUser->role === 'Admin' || $loggedInUser->role === 'Supervisor'))
<div class="modal fade" id="tambahShiftModal" tabindex="-1" aria-labelledby="tambahShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('shifts.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahShiftModalLabel">Tambah Shift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- Tanggal (Date Picker) --}}
                    <div class="mb-3">
                        <label for="shift_date" class="form-label">Tanggal</label>
                        <input type="date" name="shift_date" class="form-control" id="shift_date" required>
                    </div>

                    {{-- Pilih Pegawai (selain role="Pengguna") --}}
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Nama Pegawai</label>
                        <select name="user_id" class="form-select" id="user_id" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->role }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_jk" class="form-label">Jam Kerja</label>
                        <select name="id_jk" class="form-select" id="id_jk" required>
                            <option value="">-- Pilih Jam Kerja --</option>
                            @foreach($jamKerja as $jk)
                                <option value="{{ $jk->id_jk }}">
                                    {{ ucfirst($jk->bagian) }} ({{ $jk->jam_mulai }} - {{ $jk->jam_selesai }})
                                </option>
                            @endforeach
                        </select>
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
@endif

<style>
    /* Styling tambahan untuk kalender */
    .calendar-day {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    .calendar-day:hover {
        background-color: #f0f0f0;
    }
    .calendar-day.selected {
        background-color: #007bff;
        color: #fff;
    }
</style>

<script>
let lastSelectedCell = null;
let currentSelectedDate = null; // Menyimpan tanggal terakhir yang diklik

// Tangani klik pada setiap elemen kalender-day
document.querySelectorAll('.calendar-day').forEach(cell => {
    cell.addEventListener('click', function() {
        // Hilangkan highlight dari cell sebelumnya
        if (lastSelectedCell) {
            lastSelectedCell.classList.remove('selected');
        }

        // Highlight cell yang baru diklik
        this.classList.add('selected');
        lastSelectedCell = this;

        // Ambil day (tanggal) yang diklik
        let selectedDay = this.getAttribute('data-day');
        let month = '{{ $month }}';
        let year  = '{{ $year }}';

        // Format: YYYY-MM-DD (pastikan leading zero)
        let formattedDay   = selectedDay.toString().padStart(2, '0');
        let formattedMonth = month.toString().padStart(2, '0');
        let selectedDate   = `${year}-${formattedMonth}-${formattedDay}`;

        // Simpan di variable global (untuk modal)
        currentSelectedDate = selectedDate;

        // Tampilkan di <span id="selected-date">
        document.getElementById('selected-date').innerText = selectedDate;

        // Fetch data shift untuk tanggal tersebut
        fetch(`/shifts?date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                let tbody = document.getElementById('shift-data');
                tbody.innerHTML = '';

                if (!Array.isArray(data) || data.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="3" class="text-center">
                                Tidak ada data shift.
                            </td>
                        </tr>`;
                } else {
                    data.forEach(shift => {
                        let row = `<tr>
                            <td>${shift.user.name}</td>
                            <td>${shift.jam_kerja.bagian} (${shift.jam_kerja.jam_mulai} - ${shift.jam_kerja.jam_selesai})</td>`;


                        // Tampilkan Edit/Hapus jika role cocok
                        if ("{{ auth()->check() ? auth()->user()->role : '' }}" === "Admin"
                            || "{{ auth()->check() ? auth()->user()->role : '' }}" === "Supervisor") {
                            row += `
                                <td>
                                    <a href="/shifts/edit/${shift.id}" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                    <a href="/shifts/delete/${shift.id}" class="btn btn-danger btn-sm">
                                        Hapus
                                    </a>
                                </td>
                            `;
                        }

                        row += '</tr>';
                        tbody.innerHTML += row;
                    });
                }
            })
            .catch(error => console.error("Error fetching data:", error));
    });
});

/**
 * Fungsi untuk membersihkan / mempersiapkan form shift_date di modal
 * Jika ingin auto-set dari currentSelectedDate, tinggal aktifkan baris terkait.
 */
function clearShiftDate() {
    document.getElementById('shift_date').value = '';

    // Jika ingin langsung mengisi form shift_date dengan currentSelectedDate:
    // if (currentSelectedDate) {
    //     document.getElementById('shift_date').value = currentSelectedDate;
    // }
}

document.addEventListener("DOMContentLoaded", function () {
    let today = new Date();
    let day = today.getDate();
    let month = '{{ $month }}'; // Bulan yang sedang ditampilkan
    let year = '{{ $year }}'; // Tahun yang sedang ditampilkan

    // Pastikan month dan year sesuai dengan bulan dan tahun saat ini
    if (today.getMonth() + 1 != month || today.getFullYear() != year) {
        return;
    }

    // Format tanggal dengan leading zero
    let formattedDay = day.toString().padStart(2, '0');
    let formattedMonth = month.toString().padStart(2, '0');
    let selectedDate = `${year}-${formattedMonth}-${formattedDay}`;

    // Temukan elemen tanggal hari ini di kalender dan tandai sebagai terpilih
    let todayCell = document.querySelector(`.calendar-day[data-day='${day}']`);
    if (todayCell) {
        todayCell.classList.add('selected');
        lastSelectedCell = todayCell;
    }

    // Perbarui tampilan tanggal terpilih di halaman
    document.getElementById('selected-date').innerText = selectedDate;

    // Ambil data shift untuk tanggal hari ini
    fetch(`/shifts?date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
            let tbody = document.getElementById('shift-data');
            tbody.innerHTML = '';

            if (!Array.isArray(data) || data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center">
                            Tidak ada data shift untuk hari ini.
                        </td>
                    </tr>`;
            } else {
                data.forEach(shift => {
                    let row = `<tr>
                        <td>${shift.user.name}</td>
                        <td>${shift.jam_kerja.bagian} (${shift.jam_kerja.jam_mulai} - ${shift.jam_kerja.jam_selesai})</td>`;

                    if ("{{ auth()->check() ? auth()->user()->role : '' }}" === "Admin"
                        || "{{ auth()->check() ? auth()->user()->role : '' }}" === "Supervisor") {
                        row += `
                            <td>
                                <a href="/shifts/edit/${shift.id}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="/shifts/delete/${shift.id}" class="btn btn-danger btn-sm">Hapus</a>
                            </td>`;
                    }

                    row += '</tr>';
                    tbody.innerHTML += row;
                });
            }
        })
        .catch(error => console.error("Error fetching data:", error));
});

</script>
@endsection
