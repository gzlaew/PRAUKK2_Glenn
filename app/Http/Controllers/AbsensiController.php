<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();

        $shifts = Shift::where('shift_date', $now->format('Y-m-d'))
            ->where('user_id', $user->id)
            ->with('jamKerja')
            ->get(); // Ambil semua shift hari ini

        $absenHariIni = Absensi::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->pluck('shift_id') // Ambil ID shift yang sudah diabsen
            ->toArray();

        return view('absensi.index', compact('user', 'shifts', 'absenHariIni'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();

        // Cek apakah user memiliki shift pada hari ini
        $shift = Shift::where('shift_date', $now->format('Y-m-d'))
            ->where('user_id', $user->id)
            ->whereHas('jamKerja', function ($query) use ($now) {
                $query->where('jam_mulai', '<=', $now->format('H:i:s'))
                    ->where('jam_selesai', '>=', $now->format('H:i:s'));
            })
            ->with('jamKerja')
            ->first();

        // Jika tidak ada shift kerja yang sedang berlangsung, tampilkan pesan error
        if (!$shift) {
            return redirect()->back()->with('error', 'Tidak ada shift kerja yang sedang berlangsung saat ini.');
        }

        // Cek apakah user sudah absen hari ini
        $cekAbsensi = Absensi::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($cekAbsensi) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen hari ini.');
        }

        // Ambil jam masuk shift dari relasi `jamKerja`
        $jamMasuk = Carbon::parse($shift->jamKerja->jam_mulai);
        $selisihMenit = $jamMasuk->diffInMinutes($now, false); // False agar bisa negatif jika lebih awal

        // Tentukan status absen
        if ($selisihMenit < 0) {
            $status = 'Hadir'; // Jika user absen lebih awal atau tepat waktu
        } elseif ($selisihMenit <= 10) {
            $status = 'Hadir'; // Jika absen dalam 10 menit dari jam masuk
        } else {
            $status = 'Terlambat'; // Jika lebih dari 10 menit
        }

        // Simpan data absensi ke database
        Absensi::create([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
            'waktu_absen' => $now,
            'status' => $status
        ]);

        return redirect()->back()->with('success', 'Absen berhasil dilakukan dengan status: ' . $status);
    }
}
