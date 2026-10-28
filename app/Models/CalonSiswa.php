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
        'nik',
        'no_kk',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'anak_ke',
        'jumlah_saudara',
        'asal_tk',
        'alamat_lengkap',
        'rt_rw',
        'kelurahan_desa',
        'kecamatan',
        'kota_kabupaten',
        'nama_ayah',
        'nik_ayah',
        'pekerjaan_ayah',
        'pendidikan_ayah',
        'no_hp_ayah',
        'nama_ibu',
        'nik_ibu',
        'pekerjaan_ibu',
        'pendidikan_ibu',
        'no_hp_ibu',
        'nama_wali',
        'pekerjaan_wali',
        'no_hp_wali',
        'pendaftar_peran',
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

    public function pendaftar()
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
