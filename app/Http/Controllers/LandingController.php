<?php

namespace App\Http\Controllers;

use App\Models\JadwalPpdb;
use App\Models\Pengumuman;
use App\Models\ProfilSekolah;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        return view('welcome', [
            'profil' => Schema::hasTable('profil_sekolahs') ? ProfilSekolah::values() : [],
            'jadwals' => Schema::hasTable('jadwal_ppdbs') ? JadwalPpdb::orderBy('urutan')->orderBy('tanggal_mulai')->get() : collect(),
            'pengumumans' => Schema::hasTable('pengumumans') ? Pengumuman::latest('tanggal_publish')->limit(3)->get() : collect(),
        ]);
    }
}
