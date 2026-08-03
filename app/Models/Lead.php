<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_orang_tua',
        'no_hp',
        'nama_anak',
        'sumber_informasi',
        'catatan',
        'status',
    ];
}
