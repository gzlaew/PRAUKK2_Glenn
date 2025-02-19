<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $table = 'spareparts';
    protected $primaryKey = 'id_sparepart'; // Pastikan primary key sesuai dengan database
    public $incrementing = true;
    protected $keyType = 'int'; // Gunakan 'int', bukan 'bigint'

    protected $fillable = [
        'nama',
        'stok',
        'harga',
        'gambar'
    ];
}
