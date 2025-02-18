<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class alat extends Model
{
    use HasFactory;

    protected $table = 'alat';
    protected $primaryKey = 'id_alat';
    public $incrementing = false; // Jika `id_alat` bukan auto-increment
    protected $keyType = 'bigint'; // Pastikan sesuai dengan database

    protected $fillable = ['stok', 'keterangan', 'name', 'gambar'];
}
