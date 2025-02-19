<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\Sparepart;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Services::latest()->get();
        return view('service.index', compact('services'));
    }

    public function create()
    {
        // Ambil pegawai yang hadir, dll. (opsional)
        $pegawaiHadir = User::whereHas('absensi', function ($query) {
            $query->whereDate('created_at', now()->toDateString())
                ->where(function ($q) {
                    $q->where('status', 'Hadir')
                        ->orWhere(function ($q) {
                            $q->where('status', 'Terlambat')
                                ->whereRaw("waktu_absen::time >= (
                                SELECT jam_mulai FROM jam_kerja
                                WHERE jam_kerja.id_jk = absensis.shift_id
                            )");
                        });
                });
        })->get();

        // Ambil data sparepart
        $spareparts = Sparepart::all();

        return view('service.create', compact('pegawaiHadir', 'spareparts'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'plat_nomor'       => 'required|string|max:15',
            'nama_customer'    => 'required|string|max:255',
            'nomor_hp'         => 'required|string|max:15',
            'keluhan'          => 'required|string',
            'jenis_service'    => 'required|in:service ringan,service besar',
            'estimasi_selesai' => 'required|date_format:H:i',
            'user_id' => 'nullable|exists:users,id',

            'spareparts'            => 'sometimes|array',
            'spareparts.*.id'       => 'exists:spareparts,id_sparepart',
            'spareparts.*.jumlah'   => 'required_with:spareparts.*.id|integer|min:0',
        ]);

        // (Contoh) Biaya service
        $biayaService = ($request->jenis_service == 'service ringan') ? 50000 : 150000;

        DB::beginTransaction();
        try {
            $hargaSparepart = 0;
            $sparepartData  = [];

            if ($request->has('spareparts')) {
                foreach ($request->spareparts as $sp) {
                    if (empty($sp['id']) || $sp['jumlah'] <= 0) {
                        continue;
                    }
                    $rowSp = Sparepart::findOrFail($sp['id']);

                    if ($rowSp->stok < $sp['jumlah']) {
                        return redirect()->back()->with('error', "Stok untuk {$rowSp->nama} tidak mencukupi!");
                    }

                    // Kurangi stok
                    $rowSp->stok -= $sp['jumlah'];
                    $rowSp->save();

                    $subtotal = $rowSp->harga * $sp['jumlah'];
                    $hargaSparepart += $subtotal;

                    // Data detail sparepart
                    $sparepartData[] = [
                        'id'     => $rowSp->id_sparepart,
                        'nama'   => $rowSp->nama,
                        'harga'  => $rowSp->harga,
                        'jumlah' => $sp['jumlah']
                    ];
                }
            }

            $totalHarga = $hargaSparepart + $biayaService;

            // Insert ke DB
            $service = Services::create([
                'plat_nomor'       => $request->plat_nomor,
                'nama_customer'    => $request->nama_customer,
                'nomor_hp'         => $request->nomor_hp,
                'keluhan'          => $request->keluhan,
                'jenis_service'    => $request->jenis_service,
                'estimasi_selesai' => $request->estimasi_selesai, // jam:menit (atau datetime)
                'user_id'          => $request->user_id,
                'spareparts'       => $sparepartData,

                'harga_sparepart'  => $hargaSparepart,
                'total_harga'      => $totalHarga,
                'status'           => 'Proses', // default
            ]);

            DB::commit();
            return redirect()->route('service.index')->with('success', 'Service berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Hapus data (opsional)
    public function destroy($id)
    {
        try {
            $service = Services::findOrFail($id);
            $service->delete();

            return redirect()->route('service.index')->with('success', 'Service berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('service.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
