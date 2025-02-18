<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Riwayat;
use App\Models\Sparepart;
use Illuminate\Support\Facades\Auth;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::all();
        return view('sparepart.index', compact('spareparts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sparepart = Sparepart::create($validated);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('spareparts', 'public');
            $sparepart->gambar = $path;
            $sparepart->save();
        }

        // Catat riwayat penambahan sparepart
        $this->catatRiwayat($sparepart, 'Tambah', null, $validated);

        return redirect()->route('sparepart.index')->with('success', 'Sparepart berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return response()->json($sparepart);
    }

    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $dataLama = $sparepart->toArray();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($sparepart->gambar && Storage::disk('public')->exists($sparepart->gambar)) {
                Storage::disk('public')->delete($sparepart->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('spareparts', 'public');
        }

        $sparepart->update($validated);
        $this->catatRiwayat($sparepart, 'Edit', $dataLama, $validated);

        return redirect()->route('sparepart.index')->with('success', 'Sparepart berhasil diperbarui.');
    }

    public function addStock(Request $request)
    {
        $validated = $request->validate([
            'id_sparepart' => 'required|exists:spareparts,id_sparepart',
            'stok' => 'required|integer|min:1'
        ]);

        $sparepart = Sparepart::findOrFail($validated['id_sparepart']);
        $dataLama = ['stok' => $sparepart->stok];

        $sparepart->stok += $validated['stok'];
        $sparepart->save();

        $this->catatRiwayat($sparepart, 'Tambah Stok', $dataLama, ['stok' => $sparepart->stok]);

        return redirect()->route('sparepart.index')->with('success', 'Stok berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);

        if ($sparepart->gambar && Storage::disk('public')->exists($sparepart->gambar)) {
            Storage::disk('public')->delete($sparepart->gambar);
        }

        $sparepart->delete();
        return redirect()->route('sparepart.index')->with('success', 'Sparepart berhasil dihapus.');
    }

    private function catatRiwayat($sparepart, $aksi, $dataLama = null, $dataBaru = null)
    {
        $perubahan = '';

        if ($aksi === 'Tambah') {
            $perubahan = "Ditambahkan: {$sparepart->nama}";
        } elseif ($aksi === 'Edit' || $aksi === 'Tambah Stok') {
            if (isset($dataLama['stok']) && $dataLama['stok'] != $dataBaru['stok']) {
                $stokDiff = $dataBaru['stok'] - $dataLama['stok'];
                $perubahan = ($stokDiff > 0) ? "+$stokDiff stok" : "$stokDiff stok";
            }
            if (isset($dataLama['harga']) && $dataLama['harga'] != $dataBaru['harga']) {
                $perubahan .= " | Harga: {$dataLama['harga']} → {$dataBaru['harga']}";
            }
            if (isset($dataLama['gambar']) && isset($dataBaru['gambar']) && $dataLama['gambar'] != $dataBaru['gambar']) {
                $perubahan .= " | Gambar diubah";
            }
        } elseif ($aksi === 'Hapus') {
            $perubahan = "Sparepart {$sparepart->nama} dihapus";
        }

        Riwayat::create([
            'sparepart_id' => $sparepart->id_sparepart,
            'user_id' => Auth::id(),
            'aksi' => $aksi,
            'data_lama' => json_encode($dataLama),
            'data_baru' => json_encode($dataBaru),
            'perubahan' => $perubahan,
        ]);
    }
}
