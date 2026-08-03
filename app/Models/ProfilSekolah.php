<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    use HasFactory;

    protected $table = 'profil_sekolahs';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function values(): array
    {
        return static::pluck('value', 'key')->all();
    }
}
