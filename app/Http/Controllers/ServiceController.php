<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\Sparepart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Services::latest()->get();
        return view('service.index', compact('services'));
    }

    public function create()
    {
        $pegawaiHadir = User::whereHas('absensi', function ($query) {
            $query->whereDate('created_at', now()->toDateString())
                ->where(function ($q) {
                    $q->where('status', 'Hadir')
                        ->orWhere(function ($q) {
                            $q->where('status', 'Terlambat')
                                ->whereRaw("waktu_absen::time >= (SELECT jam_mulai FROM jam_kerja WHERE jam_kerja.id_jk = absensis.shift_id)");
                        });
                });
        })->get();

        $spareparts = Sparepart::all();
        return view('service.create', compact('pegawaiHadir', 'spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'nama_customer' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:15', // ✅ Tambahkan validasi nomor HP
            'keluhan' => 'required|string',
            'spareparts' => 'required|array',
            'spareparts.*' => 'exists:spareparts,id_sparepart',
            'user_id' => 'required|exists:users,id',
            'estimasi_selesai' => 'required|string|max:255',
        ]);

        $spareparts = Sparepart::whereIn('id_sparepart', $request->spareparts)->get();
        $hargaSparepart = $spareparts->sum('harga');

        $biayaService = count($request->spareparts) * ($request->service_type == 'ringan' ? 10000 : 30000);
        $totalHarga = $hargaSparepart + $biayaService;

        Services::create([
            'plat_nomor' => $request->plat_nomor,
            'nama_customer' => $request->nama_customer,
            'nomor_hp' => $request->nomor_hp, // ✅ Simpan nomor HP
            'keluhan' => $request->keluhan,
            'spareparts' => json_encode($request->spareparts),
            'harga_sparepart' => $hargaSparepart,
            'total_harga' => $totalHarga,
            'status' => 'Waiting',
            'user_id' => $request->user_id,
            'estimasi_selesai' => $request->estimasi_selesai,
        ]);

        return redirect()->route('service.index')->with('success', 'Service berhasil ditambahkan.');
    }
}
