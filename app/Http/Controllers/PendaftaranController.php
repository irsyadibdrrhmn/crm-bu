<?php

namespace App\Http\Controllers;

use App\Models\BerkasPendaftaran;
use App\Models\CalonSiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class PendaftaranController extends Controller
{
    public function index(): View
    {
        $pendaftar = CalonSiswa::with(['orangTua', 'berkas'])->latest()->paginate(10);

        return view('pendaftaran.index', compact('pendaftar'));
    }

    public function create(): View
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'asal_tk' => ['nullable', 'string', 'max:255'],
            'sumber_informasi' => ['nullable', 'string', 'max:255'],
            'program_diminati' => ['nullable', 'string', 'max:255'],
            'alasan_memilih' => ['nullable', 'string'],
        ]);

        $request->user()->calonSiswas()->create($data);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil dikirim.');
    }

    public function updateStatus(Request $request, CalonSiswa $calonSiswa): RedirectResponse
    {
        $data = $request->validate([
            'status_pendaftaran' => ['required', 'in:terkirim,diverifikasi,observasi,diterima,ditolak,daftar_ulang'],
            'catatan_admin' => ['nullable', 'string'],
            'jadwal_observasi' => ['nullable', 'date'],
        ]);

        $calonSiswa->update($data);

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function show(CalonSiswa $calonSiswa): View
    {
        $this->authorizeAccess($calonSiswa);

        $calonSiswa->load(['orangTua', 'berkas', 'pesan.user']);

        return view('pendaftaran.show', compact('calonSiswa'));
    }

    public function uploadBerkas(Request $request, CalonSiswa $calonSiswa): RedirectResponse
    {
        $this->authorizeAccess($calonSiswa);

        $data = $request->validate([
            'jenis_berkas' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        $path = $request->file('file')->store('berkas-ppdb', 'public');

        $calonSiswa->berkas()->create([
            'jenis_berkas' => $data['jenis_berkas'],
            'file_path' => $path,
        ]);

        return back()->with('success', 'Berkas berhasil diunggah.');
    }

    public function updateBerkas(Request $request, BerkasPendaftaran $berkas): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:menunggu,lengkap,revisi'],
            'catatan' => ['nullable', 'string'],
        ]);

        $berkas->update($request->only('status', 'catatan'));

        return back()->with('success', 'Status berkas berhasil diperbarui.');
    }

    public function kirimPesan(Request $request, CalonSiswa $calonSiswa): RedirectResponse
    {
        $this->authorizeAccess($calonSiswa);

        $data = $request->validate([
            'pesan' => ['required', 'string'],
        ]);

        $calonSiswa->pesan()->create([
            'user_id' => $request->user()->id,
            'pesan' => $data['pesan'],
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    public function export(): StreamedResponse
    {
        $fileName = 'laporan-ppdb-'.now()->format('Ymd-His').'.csv';
        $pendaftar = CalonSiswa::with('orangTua')->latest()->get();

        return response()->streamDownload(function () use ($pendaftar) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama Calon Siswa', 'Orang Tua', 'Email', 'Tanggal Lahir', 'Asal TK', 'Sumber Informasi', 'Program Diminati', 'Status']);

            foreach ($pendaftar as $siswa) {
                fputcsv($handle, [
                    $siswa->nama_lengkap,
                    $siswa->orangTua->name,
                    $siswa->orangTua->email,
                    $siswa->tanggal_lahir->format('Y-m-d'),
                    $siswa->asal_tk,
                    $siswa->sumber_informasi,
                    $siswa->program_diminati,
                    $siswa->status_pendaftaran,
                ]);
            }

            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    private function authorizeAccess(CalonSiswa $calonSiswa): void
    {
        if (auth()->user()->isAdmin()) {
            return;
        }

        abort_unless($calonSiswa->user_id === auth()->id(), 403);
    }
}
