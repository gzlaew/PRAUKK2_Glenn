<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    public function index()
    {
        $alat = Alat::all();
        return view('alat.index', compact('alat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $alat = new Alat();
        $alat->name = $validated['name'];
        $alat->keterangan = $request->keterangan ?? '';
        $alat->stok = $validated['stok'];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('gambars', 'public');
            $alat->gambar = $path;
        }

        $alat->save();

        return redirect()->route('alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        return response()->json($alat);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $alat = Alat::findOrFail($id);
        $alat->name = $validated['name'];
        $alat->keterangan = $validated['keterangan'];
        $alat->stok = $validated['stok'];

        // Proses upload gambar baru dan hapus yang lama
        if ($request->hasFile('gambar')) {
            if ($alat->gambar && Storage::disk('public')->exists($alat->gambar)) {
                Storage::disk('public')->delete($alat->gambar);
            }
            $path = $request->file('gambar')->store('gambars', 'public');
            $alat->gambar = $path;
        }

        $alat->save();

        return redirect()->route('alat.index')->with('success', 'Alat berhasil diperbarui.');
    }



    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);

        if ($alat->gambar && Storage::disk('public')->exists($alat->gambar)) {
            Storage::disk('public')->delete($alat->gambar);
        }

        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}
