<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JamKerja extends Model
{
    use HasFactory;

    protected $table = 'jam_kerja';
    protected $primaryKey = 'id_jk';
    public $timestamps = true;

    protected $fillable = ['bagian', 'jam_mulai', 'jam_selesai'];

    public function shifts()
    {
        return $this->hasMany(Shift::class, 'id_jk', 'id_jk'); // Sesuaikan foreign key
    }
}
