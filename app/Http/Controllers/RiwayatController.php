<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riwayat;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayats = Riwayat::with('user', 'sparepart')->latest()->paginate(10);
        return view('riwayat.index', compact('riwayats'));
    }
}
