<?php

namespace App\Http\Controllers;

use App\Models\BerkasPendaftaran;
use App\Models\CalonSiswa;
use App\Models\ProfilSekolah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
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
            'nik' => ['nullable', 'string', 'size:16'],
            'no_kk' => ['nullable', 'string', 'size:16'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'anak_ke' => ['nullable', 'integer', 'min:1'],
            'jumlah_saudara' => ['nullable', 'integer', 'min:0'],
            'asal_tk' => ['nullable', 'string', 'max:255'],
            'alamat_lengkap' => ['nullable', 'string'],
            'rt_rw' => ['nullable', 'string', 'max:20'],
            'kelurahan_desa' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'kota_kabupaten' => ['nullable', 'string', 'max:100'],
            'nama_ayah' => ['nullable', 'string', 'max:255'],
            'nik_ayah' => ['nullable', 'string', 'size:16'],
            'pekerjaan_ayah' => ['nullable', 'string', 'max:255'],
            'pendidikan_ayah' => ['nullable', 'string', 'max:100'],
            'no_hp_ayah' => ['nullable', 'string', 'max:30'],
            'nama_ibu' => ['nullable', 'string', 'max:255'],
            'nik_ibu' => ['nullable', 'string', 'size:16'],
            'pekerjaan_ibu' => ['nullable', 'string', 'max:255'],
            'pendidikan_ibu' => ['nullable', 'string', 'max:100'],
            'no_hp_ibu' => ['nullable', 'string', 'max:30'],
            'nama_wali' => ['nullable', 'string', 'max:255'],
            'pekerjaan_wali' => ['nullable', 'string', 'max:255'],
            'no_hp_wali' => ['nullable', 'string', 'max:30'],
            'sumber_informasi' => ['nullable', 'string', 'max:255'],
            'program_diminati' => ['nullable', 'string', 'max:255'],
            'alasan_memilih' => ['nullable', 'string'],
        ]);

        $data['pendaftar_peran'] = $request->user()->role === 'guru_tk' ? 'guru_tk' : 'orang_tua';
        if ($request->user()->role === 'guru_tk' && empty($data['sumber_informasi'])) {
            $data['sumber_informasi'] = 'Rekomendasi Guru TK';
        }
        if ($request->user()->role === 'guru_tk' && empty($data['asal_tk']) && $request->user()->asal_sekolah) {
            $data['asal_tk'] = $request->user()->asal_sekolah;
        }

        $calonSiswa = $request->user()->calonSiswas()->create($data);

        return redirect()->route('pendaftaran.detail', $calonSiswa)
            ->with('success', 'Pendaftaran berhasil dikirim. Formulir pendaftaran ananda sudah siap dicetak.')
            ->with('just_registered', true);
    }

    public function updateStatus(Request $request, CalonSiswa $calonSiswa): RedirectResponse
    {
        $data = $request->validate([
            'status_pendaftaran' => ['required', 'in:terkirim,diverifikasi,observasi,diterima,ditolak,daftar_ulang'],
            'catatan_admin' => ['nullable', 'string'],
            'jadwal_observasi' => ['nullable', 'date'],
        ]);

        $calonSiswa->update($data);

        $message = 'Status pendaftaran berhasil diperbarui.';
        if (in_array($data['status_pendaftaran'], ['diterima', 'daftar_ulang'])) {
            $message = 'Status calon siswa berhasil diperbarui menjadi Diterima. Surat pemberitahuan penerimaan kini siap dicetak.';
        }

        return back()->with('success', $message);
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

    public function cetakFormulir(Request $request, CalonSiswa $calonSiswa): Response
    {
        $this->authorizeAccess($calonSiswa);

        $calonSiswa->load(['orangTua', 'berkas']);
        $profil = ProfilSekolah::values();

        $pdf = Pdf::loadView('pendaftaran.pdf.formulir', compact('calonSiswa', 'profil'))
            ->setPaper('a4', 'portrait');

        $fileName = 'formulir-pendaftaran-'.Str::slug($calonSiswa->nama_lengkap).'.pdf';

        return $request->boolean('download')
            ? $pdf->download($fileName)
            : $pdf->stream($fileName);
    }

    public function cetakPemberitahuan(Request $request, CalonSiswa $calonSiswa): Response|RedirectResponse
    {
        $this->authorizeAccess($calonSiswa);

        if (!in_array($calonSiswa->status_pendaftaran, ['diterima', 'daftar_ulang'])) {
            return back()->with('error', 'Surat pemberitahuan hanya dapat dicetak setelah calon siswa dinyatakan diterima.');
        }

        $calonSiswa->load(['orangTua', 'berkas']);
        $profil = ProfilSekolah::values();

        $pdf = Pdf::loadView('pendaftaran.pdf.surat-penerimaan', compact('calonSiswa', 'profil'))
            ->setPaper('a4', 'portrait');

        $fileName = 'surat-pemberitahuan-diterima-'.Str::slug($calonSiswa->nama_lengkap).'.pdf';

        return $request->boolean('download')
            ? $pdf->download($fileName)
            : $pdf->stream($fileName);
    }

    private function authorizeAccess(CalonSiswa $calonSiswa): void
    {
        if (auth()->user()->isAdmin()) {
            return;
        }

        abort_unless($calonSiswa->user_id === auth()->id(), 403);
    }
}
