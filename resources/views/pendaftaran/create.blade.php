<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Formulir PPDB</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">Daftar Calon Siswa Baru</h1>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('pendaftaran.store') }}" class="panel max-w-3xl p-6">
        @csrf

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="nama_lengkap" class="label-modern">Nama Lengkap Anak</label>
                <input id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="input-modern" required>
                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
            </div>

            <div>
                <label for="tempat_lahir" class="label-modern">Tempat Lahir</label>
                <input id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="input-modern" required>
                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
            </div>

            <div>
                <label for="tanggal_lahir" class="label-modern">Tanggal Lahir</label>
                <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="input-modern" required>
                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
            </div>

            <div class="sm:col-span-2">
                <label for="asal_tk" class="label-modern">Asal TK</label>
                <input id="asal_tk" name="asal_tk" value="{{ old('asal_tk') }}" class="input-modern" placeholder="Opsional">
                <x-input-error :messages="$errors->get('asal_tk')" class="mt-2" />
            </div>

            <div>
                <label for="sumber_informasi" class="label-modern">Mengetahui Sekolah Dari</label>
                <select id="sumber_informasi" name="sumber_informasi" class="input-modern">
                    <option value="">Pilih sumber informasi</option>
                    @foreach (['Instagram', 'Facebook', 'Brosur', 'Teman/Keluarga', 'Website', 'Spanduk', 'Lainnya'] as $sumber)
                        <option value="{{ $sumber }}" @selected(old('sumber_informasi') === $sumber)>{{ $sumber }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('sumber_informasi')" class="mt-2" />
            </div>

            <div>
                <label for="program_diminati" class="label-modern">Program yang Diminati</label>
                <select id="program_diminati" name="program_diminati" class="input-modern">
                    <option value="">Pilih program</option>
                    @foreach (['Tahfidz', 'Kurikulum Islam Terpadu', 'Kelas Reguler', 'Ekstrakurikuler', 'Pembinaan Karakter'] as $program)
                        <option value="{{ $program }}" @selected(old('program_diminati') === $program)>{{ $program }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('program_diminati')" class="mt-2" />
            </div>

            <div class="sm:col-span-2">
                <label for="alasan_memilih" class="label-modern">Alasan Memilih SDIT Binaul Ummah</label>
                <textarea id="alasan_memilih" name="alasan_memilih" rows="4" class="input-modern">{{ old('alasan_memilih') }}</textarea>
                <x-input-error :messages="$errors->get('alasan_memilih')" class="mt-2" />
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('dashboard') }}" class="btn-light">Batal</a>
            <button class="btn-primary">Kirim Pendaftaran</button>
        </div>
    </form>
</x-app-layout>
