<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class presences extends Model
{
    const STATUS_HADIR     = 1;
    const STATUS_TERLAMBAT = 2;
    const STATUS_ABSEN     = 3;
    const STATUS_CUTI      = 4;

    protected $table      = "presences";
    protected $primaryKey = 'presenceId';
    protected $fillable   = [
        'presenceId',
        'user_id',
        'date',
        'entry_time',
        'latitude',
        'longitude',
        'status_presence',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
