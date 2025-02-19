<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services'; // Sesuaikan dengan nama tabel Anda

    protected $fillable = [
        'plat_nomor',
        'nama_customer',
        'nomor_hp',
        'keluhan',
        'spareparts',
        'harga_sparepart',
        'total_harga',
        'status',
        'user_id',
        'estimasi_selesai',
        'jenis_service',
    ];

    protected $casts = [
        // Agar kolom "spareparts" yang disimpan JSON
        // bisa otomatis jadi array di PHP
        'spareparts' => 'array',
    ];

    // Hapus method boot() jika ada logika yang memaksa status jadi "Selesai"
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::saving(function ($service) {
    //         // Nonaktifkan logika auto "Selesai"
    //     });
    // }

    public function pegawai()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
