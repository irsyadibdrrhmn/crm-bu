<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Enhance</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">Profil Sekolah</h1>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('profil-sekolah.update') }}" class="panel max-w-4xl p-6">
        @csrf
        @method('PATCH')

        @if (session('success'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="label-modern" for="nama_sekolah">Nama Sekolah</label>
                <input id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah', $profil['nama_sekolah'] ?? 'SDIT Binaul Ummah') }}" class="input-modern" required>
            </div>
            <div>
                <label class="label-modern" for="tagline">Tagline</label>
                <input id="tagline" name="tagline" value="{{ old('tagline', $profil['tagline'] ?? 'Belajar, berkarakter, dan bertumbuh bersama') }}" class="input-modern">
            </div>
            <div class="sm:col-span-2">
                <label class="label-modern" for="deskripsi">Deskripsi Singkat</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="input-modern">{{ old('deskripsi', $profil['deskripsi'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="label-modern" for="visi">Visi</label>
                <textarea id="visi" name="visi" rows="5" class="input-modern">{{ old('visi', $profil['visi'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="label-modern" for="misi">Misi</label>
                <textarea id="misi" name="misi" rows="5" class="input-modern">{{ old('misi', $profil['misi'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="label-modern" for="fasilitas">Fasilitas</label>
                <textarea id="fasilitas" name="fasilitas" rows="5" class="input-modern" placeholder="Satu fasilitas per baris">{{ old('fasilitas', $profil['fasilitas'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="label-modern" for="program_unggulan">Program Unggulan</label>
                <textarea id="program_unggulan" name="program_unggulan" rows="5" class="input-modern" placeholder="Satu program per baris">{{ old('program_unggulan', $profil['program_unggulan'] ?? '') }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <label class="label-modern" for="kontak">Kontak PPDB</label>
                <textarea id="kontak" name="kontak" rows="3" class="input-modern">{{ old('kontak', $profil['kontak'] ?? '') }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button class="btn-primary">Simpan Profil</button>
        </div>
    </form>
</x-app-layout>
