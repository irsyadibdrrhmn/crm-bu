<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\JadwalPpdb;
use App\Models\Lead;
use App\Models\Pengumuman;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return view('dashboard.admin', [
                'totalPendaftar' => CalonSiswa::count(),
                'pending' => CalonSiswa::whereIn('status_pendaftaran', ['pending', 'terkirim', 'diverifikasi'])->count(),
                'diterima' => CalonSiswa::where('status_pendaftaran', 'diterima')->count(),
                'ditolak' => CalonSiswa::where('status_pendaftaran', 'ditolak')->count(),
                'observasi' => CalonSiswa::where('status_pendaftaran', 'observasi')->count(),
                'daftarUlang' => CalonSiswa::where('status_pendaftaran', 'daftar_ulang')->count(),
                'totalLeads' => Lead::count(),
                'leadBaru' => Lead::where('status', 'baru')->count(),
                'pendaftarTerbaru' => CalonSiswa::with('orangTua')->latest()->limit(8)->get(),
                'sumberPendaftar' => CalonSiswa::selectRaw('COALESCE(sumber_informasi, "Tidak diisi") as sumber, count(*) as total')
                    ->groupBy('sumber')
                    ->orderByDesc('total')
                    ->limit(5)
                    ->get(),
            ]);
        }

        if (auth()->user()->isGuruTk()) {
            return view('dashboard.guru-tk', [
                'calonSiswas' => auth()->user()->calonSiswas()->with(['berkas', 'pesan.user'])->latest()->get(),
                'pengumumans' => Pengumuman::latest('tanggal_publish')->limit(5)->get(),
                'jadwals' => JadwalPpdb::orderBy('urutan')->orderBy('tanggal_mulai')->limit(5)->get(),
            ]);
        }

        return view('dashboard.orang-tua', [
            'calonSiswas' => auth()->user()->calonSiswas()->with(['berkas', 'pesan.user'])->latest()->get(),
            'pengumumans' => Pengumuman::latest('tanggal_publish')->limit(5)->get(),
            'jadwals' => JadwalPpdb::orderBy('urutan')->orderBy('tanggal_mulai')->limit(5)->get(),
        ]);
    }
}
