<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\settings;

class SettingController extends Controller
{
    public function index()
    {
        $setting = settings::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Nama Perusahaan Default',
                'address' => 'Alamat Perusahaan Default',
                'phone' => '08123456789',
                'logo' => null
            ]
        );
        return view('settings.tampil', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $setting = settings::find(1);

        if (!$setting) {
            $setting = new settings();
            $setting->id = 1;
        }

        $setting->name = $request->name;
        $setting->address = $request->address;
        $setting->phone = $request->phone;

        // Proses upload logo
        if ($request->hasFile('logo')) {
            if ($setting->logo && file_exists(storage_path('app/public/' . $setting->logo))) {
                unlink(storage_path('app/public/' . $setting->logo)); // Hapus logo lama
            }

            $path = $request->file('logo')->store('logos', 'public');
            $setting->logo = $path;
        }

        $setting->save();

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
