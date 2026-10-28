<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalitikController extends Controller
{
    public function index(): View
    {
        // 1. KPI & Funnel Konversi CRM
        $totalLeads = Lead::count();
        $totalPendaftar = CalonSiswa::count();
        $totalObservasi = CalonSiswa::whereIn('status_pendaftaran', ['observasi', 'diterima', 'daftar_ulang'])->count();
        $totalDiterima = CalonSiswa::whereIn('status_pendaftaran', ['diterima', 'daftar_ulang'])->count();
        $totalDaftarUlang = CalonSiswa::where('status_pendaftaran', 'daftar_ulang')->count();
        $totalDitolak = CalonSiswa::where('status_pendaftaran', 'ditolak')->count();

        // Conversion Rates
        $rateLeadToRegister = $totalLeads > 0 ? round(($totalPendaftar / $totalLeads) * 100, 1) : 0;
        $rateAcceptance = $totalPendaftar > 0 ? round(($totalDiterima / $totalPendaftar) * 100, 1) : 0;
        $rateEnrollment = $totalDiterima > 0 ? round(($totalDaftarUlang / $totalDiterima) * 100, 1) : 0;
        $rateOverall = $totalLeads > 0 ? round(($totalDaftarUlang / $totalLeads) * 100, 1) : 0;

        // 2. Tren Pendaftaran Bulanan (6 bulan terakhir)
        if (DB::getDriverName() === 'sqlite') {
            $pendaftaranBulanan = CalonSiswa::selectRaw("strftime('%Y-%m', created_at) as periode, count(*) as total")
                ->groupBy('periode')
                ->orderBy('periode')
                ->limit(6)
                ->get()
                ->map(function ($item) {
                    $item->bulan = \Carbon\Carbon::parse($item->periode . '-01')->locale('id')->translatedFormat('M Y');
                    return $item;
                });
        } else {
            $pendaftaranBulanan = CalonSiswa::selectRaw("DATE_FORMAT(created_at, '%b %Y') as bulan, DATE_FORMAT(created_at, '%Y-%m') as periode, count(*) as total")
                ->groupBy('periode', 'bulan')
                ->orderBy('periode')
                ->limit(6)
                ->get();
        }

        // 3. Distribusi Program Peminatan
        $programPeminatan = CalonSiswa::selectRaw('COALESCE(program_diminati, "Reguler") as program, count(*) as total')
            ->groupBy('program')
            ->orderByDesc('total')
            ->get();

        // 4. Analisis Sekolah Asal (TK Mitra / Feeder Schools)
        $tkMitra = CalonSiswa::selectRaw('COALESCE(asal_tk, "Mandiri / Tanpa TK") as nama_tk, count(*) as total, SUM(CASE WHEN status_pendaftaran IN ("diterima", "daftar_ulang") THEN 1 ELSE 0 END) as total_diterima')
            ->groupBy('nama_tk')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        // 5. Efektivitas Saluran Marketing / Sumber Informasi
        $sumberMarketing = CalonSiswa::selectRaw('COALESCE(sumber_informasi, "Lainnya") as sumber, count(*) as total, SUM(CASE WHEN status_pendaftaran IN ("diterima", "daftar_ulang") THEN 1 ELSE 0 END) as total_diterima')
            ->groupBy('sumber')
            ->orderByDesc('total')
            ->get();

        // 6. Demografi Jenis Kelamin
        $genderLaki = CalonSiswa::where('jenis_kelamin', 'L')->count();
        $genderPerempuan = CalonSiswa::where('jenis_kelamin', 'P')->count();
        $genderBelumDiisi = CalonSiswa::whereNull('jenis_kelamin')->count();

        // 7. Kontribusi Guru TK vs Orang Tua Mandiri
        $pendaftarGuruTk = CalonSiswa::where('pendaftar_peran', 'guru_tk')->count();
        $pendaftarOrangTua = CalonSiswa::where('pendaftar_peran', '!=', 'guru_tk')->orWhereNull('pendaftar_peran')->count();
        $totalAkunGuruTk = User::where('role', 'guru_tk')->count();

        return view('analitik.index', compact(
            'totalLeads',
            'totalPendaftar',
            'totalObservasi',
            'totalDiterima',
            'totalDaftarUlang',
            'totalDitolak',
            'rateLeadToRegister',
            'rateAcceptance',
            'rateEnrollment',
            'rateOverall',
            'pendaftaranBulanan',
            'programPeminatan',
            'tkMitra',
            'sumberMarketing',
            'genderLaki',
            'genderPerempuan',
            'genderBelumDiisi',
            'pendaftarGuruTk',
            'pendaftarOrangTua',
            'totalAkunGuruTk'
        ));
    }
}
