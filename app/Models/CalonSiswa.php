<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_tk',
        'status_pendaftaran',
        'sumber_informasi',
        'program_diminati',
        'alasan_memilih',
        'catatan_admin',
        'jadwal_observasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'jadwal_observasi' => 'datetime',
        ];
    }

    public function orangTua()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function berkas()
    {
        return $this->hasMany(BerkasPendaftaran::class);
    }

    public function pesan()
    {
        return $this->hasMany(PesanPendaftaran::class);
    }
}
