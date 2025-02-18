<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Sparepart;
use App\Models\Alat;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('user', 'sparepart', 'alat')->latest()->get();
        $spareparts = Sparepart::all(); // Pastikan mengambil semua sparepart
        $alats = Alat::all(); // Pastikan mengambil semua alat

        return view('peminjaman.index', compact('peminjamans', 'spareparts', 'alats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|integer',
            'jenis_barang' => 'required|in:alat,sparepart',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Tentukan barangnya (Alat atau Sparepart)
        if ($validated['jenis_barang'] == 'alat') {
            $barang = Alat::findOrFail($validated['barang_id']);
        } else {
            $barang = Sparepart::findOrFail($validated['barang_id']);
        }

        // Pastikan stok cukup
        if ($barang->stok < $validated['jumlah']) {
            return back()->with('error', 'Stok tidak mencukupi untuk peminjaman ini!');
        }

        // Kurangi stok barang
        $barang->stok -= $validated['jumlah'];
        $barang->save();

        // Simpan data peminjaman
        Peminjaman::create([
            'user_id' => Auth::id(),
            'barang_id' => $validated['barang_id'],
            'jenis_barang' => $validated['jenis_barang'],
            'jumlah' => $validated['jumlah'],
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function returnItem($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->dikembalikan) {
            return back()->with('error', 'Barang sudah dikembalikan sebelumnya!');
        }

        // Kembalikan stok
        if ($peminjaman->jenis_barang == 'alat') {
            $barang = Alat::findOrFail($peminjaman->barang_id);
        } else {
            $barang = Sparepart::findOrFail($peminjaman->barang_id);
        }

        $barang->stok += $peminjaman->jumlah;
        $barang->save();

        // Tandai sebagai dikembalikan
        $peminjaman->dikembalikan = true;
        $peminjaman->save();

        return redirect()->route('peminjaman.index')->with('success', 'Barang berhasil dikembalikan!');
    }
}
