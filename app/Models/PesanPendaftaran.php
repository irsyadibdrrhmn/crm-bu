<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanPendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'calon_siswa_id',
        'user_id',
        'pesan',
    ];

    public function calonSiswa()
    {
        return $this->belongsTo(CalonSiswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
