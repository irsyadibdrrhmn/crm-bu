<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilSekolahController extends Controller
{
    public function edit(): View
    {
        return view('profil-sekolah.edit', [
            'profil' => ProfilSekolah::values(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'visi' => ['nullable', 'string'],
            'misi' => ['nullable', 'string'],
            'fasilitas' => ['nullable', 'string'],
            'program_unggulan' => ['nullable', 'string'],
            'kontak' => ['nullable', 'string'],
        ]);

        foreach ($data as $key => $value) {
            ProfilSekolah::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
