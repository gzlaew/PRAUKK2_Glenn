<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $fillable = [
        'plat_nomor',
        'nama_customer',
        'nomor_hp', // ✅ Tambahkan nomor HP
        'keluhan',
        'spareparts',
        'harga_sparepart',
        'total_harga',
        'status',
        'user_id',
        'estimasi_selesai'
    ];

    protected $casts = [
        'spareparts' => 'array',
    ];

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
