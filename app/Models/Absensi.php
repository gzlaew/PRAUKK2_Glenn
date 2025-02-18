<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'user_id',
        'shift_id',
        'waktu_absen',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    public function jamKerja()
    {
        return $this->hasOneThrough(JamKerja::class, Shift::class, 'id', 'id_jk', 'shift_id', 'id_jk');
    }
}
