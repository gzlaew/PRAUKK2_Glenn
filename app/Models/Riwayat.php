<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = 'riwayats';
    protected $primaryKey = 'id_riwayat';
    public $timestamps = true;

    protected $fillable = [
        'sparepart_id',
        'user_id',
        'aksi',
        'data_lama',
        'data_baru',
        'perubahan'
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'sparepart_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
