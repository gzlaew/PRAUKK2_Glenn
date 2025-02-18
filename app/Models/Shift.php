<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shift_date',
        'id_jk',
    ];

    protected $casts = [
        'shift_date' => 'datetime:Y-m-d H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jamKerja()
    {
        return $this->belongsTo(JamKerja::class, 'id_jk', 'id_jk');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'shift_id');
    }
}
