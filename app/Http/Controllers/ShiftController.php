<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use App\Models\JamKerja;

class ShiftController extends Controller
{
    /**
     * Menampilkan halaman shift (kalender & data shift)
     */
    public function index(Request $request)
    {
        $month = $request->query('month');
        $year  = $request->query('year');

        if (empty($month) || empty($year)) {
            $now   = Carbon::now();
            $month = $now->month;
            $year  = $now->year;
        }

        $firstOfMonth = Carbon::create($year, $month, 1);
        $daysInMonth = $firstOfMonth->daysInMonth;
        $startDay    = $firstOfMonth->dayOfWeek;

        $next = $firstOfMonth->copy()->addMonth();
        $prev = $firstOfMonth->copy()->subMonth();

        $nextMonth = $next->month;
        $nextYear  = $next->year;
        $prevMonth = $prev->month;
        $prevYear  = $prev->year;

        // Ambil daftar pegawai yang bukan role 'Pengguna'
        $users = User::where('role', '!=', 'Pengguna')->get();


        // **Ambil semua data Jam Kerja**
        $jamKerja = JamKerja::all(); // <== Pastikan ini ditambahkan

        return view('shift.index', compact(
            'month',
            'year',
            'startDay',
            'daysInMonth',
            'prevMonth',
            'prevYear',
            'nextMonth',
            'nextYear',
            'users',
            'jamKerja' // Pastikan variabel ini dikirim ke tampilan
        ));
    }

    /**
     * Mengambil data shift via AJAX (JSON) berdasarkan ?date=YYYY-MM-DD
     */
    public function getShifts(Request $request)
    {
        $date = $request->query('date');

        if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return response()->json(['error' => 'Tanggal tidak valid'], 400);
        }

        try {
            $parsedDate = Carbon::createFromFormat('Y-m-d', $date)->toDateString();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Format tanggal tidak sesuai'], 400);
        }

        // Ambil data shift yang match dengan tanggal + relasi jam kerja
        $shifts = Shift::whereDate('shift_date', $parsedDate)
            ->with('user', 'jamKerja') // Pastikan relasi jam kerja dimuat
            ->get();

        return response()->json($shifts);
    }

    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shift_date' => 'required|date',
            'user_id'    => 'required|exists:users,id',
            'id_jk'      => 'required|exists:jam_kerja,id_jk', // Pastikan kolom id_jk sesuai di database
        ]);

        // Debugging apakah id_jk dikirim
        if (!$request->has('id_jk') || empty($request->id_jk)) {
            return back()->withErrors(['id_jk' => 'Jam kerja harus dipilih!']);
        }

        // Simpan ke database
        Shift::create([
            'shift_date' => $validated['shift_date'],
            'user_id'    => $validated['user_id'],
            'id_jk'      => $validated['id_jk'], // Pastikan nama field sesuai dengan database
        ]);

        return redirect()->route('shift.index')->with('success', 'Shift berhasil ditambahkan.');
    }




    public function edit($id)
    {
        // Ambil data shift yang mau diedit
        $shift = Shift::findOrFail($id);

        // Tampilkan view edit (bisa pakai form)
        return view('shift.edit', compact('shift'));
    }

    public function update(Request $request, $id)
    {
        // Validasi
        $validated = $request->validate([
            'shift_date' => 'required|date',
            'user_id'    => 'required|exists:users,id',
            'hour'       => 'required|in:Shift Pagi 06:00-12:00,Shift Siang 12:00-18:00,Shift Malam 18:00-00:00',
        ]);

        // Update data
        $shift = Shift::findOrFail($id);
        $shift->update($validated);

        return redirect()->route('shift.index')->with('success', 'Shift berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->delete();

        return redirect()->route('shift.index')->with('success', 'Shift berhasil dihapus.');
    }
}
