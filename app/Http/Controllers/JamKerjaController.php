<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JamKerja;

class JamKerjaController extends Controller
{
    public function index()
    {
        $jamKerja = JamKerja::all();
        return view('jamkerja.index', compact('jamKerja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bagian' => 'required|in:pagi,siang,malam',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
        ]);

        JamKerja::create($request->all());
        return redirect()->back()->with('success', 'Jam Kerja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jamKerja = JamKerja::findOrFail($id);
        return response()->json($jamKerja);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bagian' => 'required|in:pagi,siang,malam',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
        ]);

        $jamKerja = JamKerja::findOrFail($id);
        $jamKerja->update($request->all());

        return redirect()->back()->with('success', 'Jam Kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        JamKerja::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jam Kerja berhasil dihapus.');
    }
}
