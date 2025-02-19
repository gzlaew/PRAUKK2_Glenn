<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Sparepart;
use App\Models\Alat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = peminjaman::latest()->get();
        return view('peminjaman.index', compact('peminjaman'));
    }


    public function create()
    {
        $lastPeminjaman = Peminjaman::latest()->first();
        $kodePeminjaman = 'PMJ-' . str_pad(($lastPeminjaman->id ?? 0) + 1, 5, '0', STR_PAD_LEFT);

        $alat = Alat::where('stok', '>', 0)->get();
        $users = User::all();

        return view('peminjaman.create', compact('kodePeminjaman', 'alat', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'alat_id' => 'required|exists:alat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pengajuan' => 'required|date',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        if ($alat->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk dipinjam!');
        }

        $kodePeminjaman = 'PMJ-' . str_pad(Peminjaman::count() + 1, 5, '0', STR_PAD_LEFT);

        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => $kodePeminjaman,
            'user_id' => $request->user_id,
            'alat_id' => $request->alat_id,
            'jumlah' => $request->jumlah,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'status' => 'pengajuan',
            'keterangan' => $request->keterangan,
        ]);

        // Kurangi stok alat


        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan!');
    }
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $alat = Alat::findOrFail($peminjaman->alat_id);

        if ($alat->stok < $peminjaman->jumlah) {
            return redirect()->back()->with('error', 'Stok alat tidak mencukupi!');
        }

        $alat->decrement('stok', $peminjaman->jumlah);
        $peminjaman->update(['status' => 'dipinjam']);

        return redirect()->to('peminjaman')->with('success', 'Peminjaman telah disetujui.');
    }

    // Menolak pengajuan peminjaman
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'ditolak']);

        return redirect()->to('peminjaman')->with('success', 'Peminjaman telah ditolak.');
    }

    // Mengembalikan alat dan menambah stok
    public function kembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $alat = Alat::findOrFail($peminjaman->alat_id);

        $alat->increment('stok', $peminjaman->jumlah);
        $peminjaman->update([
            'tanggal_kembali' => now(),
            'status' => 'dikembalikan'
        ]);

        return redirect()->to('peminjaman')->with('success', 'Alat telah dikembalikan.');
    }


    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $alat = Alat::all();
        $users = User::all();

        return view('peminjaman.edit', compact('peminjaman', 'alat', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pengajuan,diterima,ditolak,dikembalikan',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $alat = Alat::findOrFail($peminjaman->alat_id);

        if ($request->status == 'dikembalikan' && $peminjaman->status != 'dikembalikan') {
            $alat->increment('stok', $peminjaman->jumlah);
        }

        $peminjaman->update([
            'status' => $request->status,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Status peminjaman diperbarui!');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $alat = Alat::findOrFail($peminjaman->alat_id);

        if ($peminjaman->status != 'dikembalikan') {
            $alat->increment('stok', $peminjaman->jumlah);
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus!');
    }
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['alat', 'user'])->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }
}
