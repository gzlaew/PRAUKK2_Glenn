<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class satuan extends Model
{
    use HasFactory;

    protected $table = 'satuan';
    protected $primaryKey = 'kode_satuan';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'kode_satuan',
        'nama_satuan'
    ];
}
