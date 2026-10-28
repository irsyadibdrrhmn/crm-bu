<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Formulir PPDB Resmi</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">Formulir Pendaftaran Calon Siswa Baru</h1>
            <p class="mt-1 text-sm text-slate-500">Silakan lengkapi biodata calon siswa sesuai kartu keluarga (KK) dan formulir pendaftaran manual.</p>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('pendaftaran.store') }}" class="panel max-w-4xl p-6 md:p-8">
        @csrf

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                <p class="font-bold">Mohon periksa kembali isian formulir Anda:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (auth()->user()->isGuruTk())
            <div class="mb-6 rounded-lg border border-sky-200 bg-sky-50 p-4 text-sm text-sky-900 flex items-center justify-between">
                <div>
                    <span class="font-bold">Pendaftaran oleh Guru TK:</span> {{ auth()->user()->name }} ({{ auth()->user()->asal_sekolah ?: 'TK Mitra' }})
                    <p class="text-xs text-sky-700 mt-0.5">Asal TK akan otomatis terisi sesuai lembaga Anda. Silakan isi data calon siswa dan orang tuanya.</p>
                </div>
            </div>
        @endif

        <div class="space-y-8">
            <!-- Bagian 1: Data Identitas Calon Siswa -->
            <div>
                <div class="border-b border-emerald-100 pb-3">
                    <h2 class="text-lg font-bold text-emerald-900">1. Identitas Calon Peserta Didik</h2>
                    <p class="text-xs text-slate-500">Sesuaikan dengan data Akta Kelahiran dan Kartu Keluarga.</p>
                </div>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="nama_lengkap" class="label-modern">Nama Lengkap Anak <span class="text-rose-500">*</span></label>
                        <input id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="input-modern" placeholder="Sesuai akta kelahiran" required>
                        <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-1" />
                    </div>

                    <div>
                        <label for="nik" class="label-modern">NIK Calon Siswa (16 Digit)</label>
                        <input id="nik" name="nik" value="{{ old('nik') }}" class="input-modern" maxlength="16" placeholder="Contoh: 3201xxxxxxxxxxxx">
                        <p class="mt-1 text-[11px] text-slate-500">Nomor Induk Kependudukan yang tertera pada Kartu Keluarga / KIA.</p>
                        <x-input-error :messages="$errors->get('nik')" class="mt-1" />
                    </div>

                    <div>
                        <label for="no_kk" class="label-modern">Nomor Kartu Keluarga (KK)</label>
                        <input id="no_kk" name="no_kk" value="{{ old('no_kk') }}" class="input-modern" maxlength="16" placeholder="Contoh: 3201xxxxxxxxxxxx">
                        <x-input-error :messages="$errors->get('no_kk')" class="mt-1" />
                    </div>

                    <div>
                        <label for="tempat_lahir" class="label-modern">Tempat Lahir <span class="text-rose-500">*</span></label>
                        <input id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="input-modern" placeholder="Kota/Kabupaten kelahiran" required>
                        <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-1" />
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="label-modern">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="input-modern" required>
                        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-1" />
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="label-modern">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="input-modern">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-1" />
                    </div>

                    <div>
                        <label for="asal_tk" class="label-modern">Asal TK / RA / PAUD</label>
                        <input id="asal_tk" name="asal_tk" value="{{ old('asal_tk', auth()->user()->isGuruTk() ? auth()->user()->asal_sekolah : '') }}" class="input-modern" placeholder="Nama sekolah TK sebelumnya">
                        <x-input-error :messages="$errors->get('asal_tk')" class="mt-1" />
                    </div>

                    <div>
                        <label for="anak_ke" class="label-modern">Anak Ke-</label>
                        <input id="anak_ke" type="number" min="1" name="anak_ke" value="{{ old('anak_ke') }}" class="input-modern" placeholder="Contoh: 1">
                        <x-input-error :messages="$errors->get('anak_ke')" class="mt-1" />
                    </div>

                    <div>
                        <label for="jumlah_saudara" class="label-modern">Dari ... Bersaudara</label>
                        <input id="jumlah_saudara" type="number" min="0" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" class="input-modern" placeholder="Contoh: 3">
                        <x-input-error :messages="$errors->get('jumlah_saudara')" class="mt-1" />
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Alamat Tempat Tinggal -->
            <div>
                <div class="border-b border-emerald-100 pb-3">
                    <h2 class="text-lg font-bold text-emerald-900">2. Alamat Tempat Tinggal</h2>
                    <p class="text-xs text-slate-500">Alamat domisili tempat tinggal calon siswa saat ini.</p>
                </div>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="alamat_lengkap" class="label-modern">Alamat Lengkap (Jalan / Dusun / No. Rumah)</label>
                        <textarea id="alamat_lengkap" name="alamat_lengkap" rows="2" class="input-modern" placeholder="Contoh: Jl. KH. Ahmad Dahlan No. 12">{{ old('alamat_lengkap') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat_lengkap')" class="mt-1" />
                    </div>

                    <div>
                        <label for="rt_rw" class="label-modern">RT / RW</label>
                        <input id="rt_rw" name="rt_rw" value="{{ old('rt_rw') }}" class="input-modern" placeholder="Contoh: 03/05">
                        <x-input-error :messages="$errors->get('rt_rw')" class="mt-1" />
                    </div>

                    <div>
                        <label for="kelurahan_desa" class="label-modern">Kelurahan / Desa</label>
                        <input id="kelurahan_desa" name="kelurahan_desa" value="{{ old('kelurahan_desa') }}" class="input-modern" placeholder="Contoh: Sukaraja">
                        <x-input-error :messages="$errors->get('kelurahan_desa')" class="mt-1" />
                    </div>

                    <div>
                        <label for="kecamatan" class="label-modern">Kecamatan</label>
                        <input id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" class="input-modern" placeholder="Contoh: Cibinong">
                        <x-input-error :messages="$errors->get('kecamatan')" class="mt-1" />
                    </div>

                    <div>
                        <label for="kota_kabupaten" class="label-modern">Kota / Kabupaten</label>
                        <input id="kota_kabupaten" name="kota_kabupaten" value="{{ old('kota_kabupaten') }}" class="input-modern" placeholder="Contoh: Kab. Bogor">
                        <x-input-error :messages="$errors->get('kota_kabupaten')" class="mt-1" />
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Data Orang Tua / Wali -->
            <div>
                <div class="border-b border-emerald-100 pb-3">
                    <h2 class="text-lg font-bold text-emerald-900">3. Data Orang Tua / Wali Siswa</h2>
                    <p class="text-xs text-slate-500">Data ayah, ibu, atau wali yang bertanggung jawab atas calon siswa.</p>
                </div>

                <div class="mt-5 space-y-6">
                    <!-- Data Ayah -->
                    <div class="rounded-lg border border-slate-200 bg-slate-50/60 p-4">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700 mb-3">A. Data Ayah Kandung</h3>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="nama_ayah" class="label-modern">Nama Lengkap Ayah</label>
                                <input id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}" class="input-modern" placeholder="Nama ayah">
                                <x-input-error :messages="$errors->get('nama_ayah')" class="mt-1" />
                            </div>
                            <div>
                                <label for="nik_ayah" class="label-modern">NIK Ayah (16 Digit)</label>
                                <input id="nik_ayah" name="nik_ayah" value="{{ old('nik_ayah') }}" class="input-modern" maxlength="16" placeholder="3201xxxxxxxxxxxx">
                                <x-input-error :messages="$errors->get('nik_ayah')" class="mt-1" />
                            </div>
                            <div>
                                <label for="pekerjaan_ayah" class="label-modern">Pekerjaan Ayah</label>
                                <input id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" class="input-modern" placeholder="Contoh: Karyawan Swasta / PNS / Wiraswasta">
                                <x-input-error :messages="$errors->get('pekerjaan_ayah')" class="mt-1" />
                            </div>
                            <div>
                                <label for="pendidikan_ayah" class="label-modern">Pendidikan Terakhir Ayah</label>
                                <select id="pendidikan_ayah" name="pendidikan_ayah" class="input-modern">
                                    <option value="">Pilih pendidikan</option>
                                    @foreach (['SMA/SMK', 'D3', 'S1', 'S2', 'S3', 'Lainnya'] as $pend)
                                        <option value="{{ $pend }}" @selected(old('pendidikan_ayah') === $pend)>{{ $pend }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('pendidikan_ayah')" class="mt-1" />
                            </div>
                            <div class="sm:col-span-2">
                                <label for="no_hp_ayah" class="label-modern">Nomor WhatsApp / HP Ayah</label>
                                <input id="no_hp_ayah" name="no_hp_ayah" value="{{ old('no_hp_ayah') }}" class="input-modern" placeholder="08xxxxxxxxxx">
                                <x-input-error :messages="$errors->get('no_hp_ayah')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    <!-- Data Ibu -->
                    <div class="rounded-lg border border-slate-200 bg-slate-50/60 p-4">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700 mb-3">B. Data Ibu Kandung</h3>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="nama_ibu" class="label-modern">Nama Lengkap Ibu</label>
                                <input id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" class="input-modern" placeholder="Nama ibu">
                                <x-input-error :messages="$errors->get('nama_ibu')" class="mt-1" />
                            </div>
                            <div>
                                <label for="nik_ibu" class="label-modern">NIK Ibu (16 Digit)</label>
                                <input id="nik_ibu" name="nik_ibu" value="{{ old('nik_ibu') }}" class="input-modern" maxlength="16" placeholder="3201xxxxxxxxxxxx">
                                <x-input-error :messages="$errors->get('nik_ibu')" class="mt-1" />
                            </div>
                            <div>
                                <label for="pekerjaan_ibu" class="label-modern">Pekerjaan Ibu</label>
                                <input id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" class="input-modern" placeholder="Contoh: Ibu Rumah Tangga / PNS / Swasta">
                                <x-input-error :messages="$errors->get('pekerjaan_ibu')" class="mt-1" />
                            </div>
                            <div>
                                <label for="pendidikan_ibu" class="label-modern">Pendidikan Terakhir Ibu</label>
                                <select id="pendidikan_ibu" name="pendidikan_ibu" class="input-modern">
                                    <option value="">Pilih pendidikan</option>
                                    @foreach (['SMA/SMK', 'D3', 'S1', 'S2', 'S3', 'Lainnya'] as $pend)
                                        <option value="{{ $pend }}" @selected(old('pendidikan_ibu') === $pend)>{{ $pend }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('pendidikan_ibu')" class="mt-1" />
                            </div>
                            <div class="sm:col-span-2">
                                <label for="no_hp_ibu" class="label-modern">Nomor WhatsApp / HP Ibu</label>
                                <input id="no_hp_ibu" name="no_hp_ibu" value="{{ old('no_hp_ibu') }}" class="input-modern" placeholder="08xxxxxxxxxx">
                                <x-input-error :messages="$errors->get('no_hp_ibu')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    <!-- Data Wali (Opsional) -->
                    <div class="rounded-lg border border-dashed border-slate-200 p-4">
                        <h3 class="text-sm font-semibold text-slate-600 mb-2">C. Data Wali (Hanya diisi jika tinggal bersama wali)</h3>
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div>
                                <label for="nama_wali" class="label-modern">Nama Wali</label>
                                <input id="nama_wali" name="nama_wali" value="{{ old('nama_wali') }}" class="input-modern" placeholder="Opsional">
                            </div>
                            <div>
                                <label for="pekerjaan_wali" class="label-modern">Pekerjaan Wali</label>
                                <input id="pekerjaan_wali" name="pekerjaan_wali" value="{{ old('pekerjaan_wali') }}" class="input-modern" placeholder="Opsional">
                            </div>
                            <div>
                                <label for="no_hp_wali" class="label-modern">No. HP Wali</label>
                                <input id="no_hp_wali" name="no_hp_wali" value="{{ old('no_hp_wali') }}" class="input-modern" placeholder="Opsional">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 4: Peminatan Program & Alasan -->
            <div>
                <div class="border-b border-emerald-100 pb-3">
                    <h2 class="text-lg font-bold text-emerald-900">4. Peminatan Program & Informasi</h2>
                    <p class="text-xs text-slate-500">Program pilihan dan referensi pendaftaran sekolah.</p>
                </div>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="program_diminati" class="label-modern">Program yang Diminati</label>
                        <select id="program_diminati" name="program_diminati" class="input-modern">
                            <option value="">Pilih program peminatan</option>
                            @foreach (['Tahfidz', 'Kurikulum Islam Terpadu', 'Kelas Reguler', 'Ekstrakurikuler', 'Pembinaan Karakter'] as $program)
                                <option value="{{ $program }}" @selected(old('program_diminati') === $program)>{{ $program }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('program_diminati')" class="mt-1" />
                    </div>

                    <div>
                        <label for="sumber_informasi" class="label-modern">Mengetahui Informasi Sekolah Dari</label>
                        <select id="sumber_informasi" name="sumber_informasi" class="input-modern">
                            <option value="">Pilih sumber informasi</option>
                            @foreach (['Instagram', 'Facebook', 'Brosur', 'Teman/Keluarga', 'Website', 'Spanduk', 'Rekomendasi Guru TK', 'Lainnya'] as $sumber)
                                <option value="{{ $sumber }}" @selected(old('sumber_informasi', auth()->user()->isGuruTk() ? 'Rekomendasi Guru TK' : '') === $sumber)>{{ $sumber }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('sumber_informasi')" class="mt-1" />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="alasan_memilih" class="label-modern">Alasan Memilih SDIT Binaul Ummah</label>
                        <textarea id="alasan_memilih" name="alasan_memilih" rows="3" class="input-modern" placeholder="Tuliskan harapan atau alasan mempercayakan pendidikan ananda di sekolah ini...">{{ old('alasan_memilih') }}</textarea>
                        <x-input-error :messages="$errors->get('alasan_memilih')" class="mt-1" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-emerald-100 pt-5">
            <a href="{{ route('dashboard') }}" class="btn-light">Batal</a>
            <button class="btn-primary">Kirim & Simpan Formulir</button>
        </div>
    </form>
</x-app-layout>
