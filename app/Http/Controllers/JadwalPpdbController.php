<?php

namespace App\Http\Controllers;

use App\Models\JadwalPpdb;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalPpdbController extends Controller
{
    public function index(): View
    {
        $jadwals = JadwalPpdb::orderBy('urutan')->orderBy('tanggal_mulai')->paginate(10);

        return view('jadwal-ppdb.index', compact('jadwals'));
    }

    public function store(Request $request): RedirectResponse
    {
        JadwalPpdb::create($this->validated($request));

        return back()->with('success', 'Jadwal PPDB berhasil ditambahkan.');
    }

    public function update(Request $request, JadwalPpdb $jadwalPpdb): RedirectResponse
    {
        $jadwalPpdb->update($this->validated($request));

        return back()->with('success', 'Jadwal PPDB berhasil diperbarui.');
    }

    public function destroy(JadwalPpdb $jadwalPpdb): RedirectResponse
    {
        $jadwalPpdb->delete();

        return back()->with('success', 'Jadwal PPDB berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'tahapan' => ['required', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'keterangan' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
