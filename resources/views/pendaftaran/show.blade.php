<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Detail Pendaftaran</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900">{{ $calonSiswa->nama_lengkap }}</h1>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('pendaftaran.cetak-formulir', $calonSiswa) }}" target="_blank" class="btn-secondary !py-2 inline-flex items-center gap-1.5 text-xs font-semibold">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Formulir (PDF)
                </a>
                @if (in_array($calonSiswa->status_pendaftaran, ['diterima', 'daftar_ulang']))
                    <a href="{{ route('pendaftaran.cetak-pemberitahuan', $calonSiswa) }}" target="_blank" class="btn-primary !py-2 inline-flex items-center gap-1.5 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Cetak Surat Diterima (PDF)
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    @if (session('just_registered'))
        <div class="mb-6 rounded-lg border border-emerald-300 bg-emerald-50 p-5 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h2 class="text-lg font-bold text-emerald-950">Pendaftaran Berhasil Dikirim!</h2>
                    </div>
                    <p class="mt-1 text-sm text-emerald-800">
                        Data calon siswa atas nama <strong>{{ $calonSiswa->nama_lengkap }}</strong> telah tersimpan di sistem PPDB. Anda dapat langsung mencetak formulir pendaftaran ini sebagai bukti pendaftaran resmi, serta mengunggah kelengkapan berkas di bawah.
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('pendaftaran.cetak-formulir', $calonSiswa) }}" target="_blank" class="btn-primary inline-flex items-center gap-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak Formulir Sekarang (PDF)
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if (in_array($calonSiswa->status_pendaftaran, ['diterima', 'daftar_ulang']))
        <div class="mb-6 rounded-lg border border-emerald-300 bg-gradient-to-r from-emerald-100 via-emerald-50 to-emerald-100 p-5 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <svg class="h-6 w-6 text-emerald-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <h2 class="text-lg font-bold text-emerald-950">Alhamdulillah! Calon Siswa Dinyatakan DITERIMA</h2>
                    </div>
                    <p class="mt-1 text-sm text-emerald-800">
                        Selamat! Calon siswa telah memenuhi kriteria dan diterima di SDIT Binaul Ummah. Surat keputusan / pemberitahuan penerimaan resmi telah diterbitkan dan dapat dicetak sebagai dokumen resmi.
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('pendaftaran.cetak-pemberitahuan', $calonSiswa) }}" target="_blank" class="btn-primary inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Cetak Surat Pemberitahuan Diterima (PDF)
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[1fr_0.9fr]">
        <div class="space-y-6">
            @if (session('success') && !session('just_registered'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">{{ session('error') }}</div>
            @endif

            <div class="panel p-6">
                <div class="flex items-start justify-between gap-4 border-b border-emerald-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-lg font-bold text-slate-900">Biodata Calon Siswa</h2>
                            @if ($calonSiswa->pendaftar_peran === 'guru_tk')
                                <span class="rounded bg-sky-100 px-2 py-0.5 text-xs font-semibold text-sky-800">Didaftarkan oleh Guru TK</span>
                            @endif
                        </div>
                        <p class="mt-1 text-xs text-slate-500">
                            Akun Pendaftar: <strong>{{ $calonSiswa->orangTua->name }}</strong> ({{ $calonSiswa->orangTua->email }})
                            @if ($calonSiswa->orangTua->asal_sekolah)
                                &bull; Mitra: {{ $calonSiswa->orangTua->asal_sekolah }}
                            @endif
                        </p>
                    </div>
                    @include('pendaftaran.partials.status-badge', ['status' => $calonSiswa->status_pendaftaran])
                </div>

                <!-- Bagian Identitas Siswa -->
                <div class="mt-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded">1. Identitas Siswa</h3>
                    <dl class="mt-3 grid gap-3 sm:grid-cols-2 text-sm">
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">NIK Calon Siswa</dt><dd class="font-semibold text-slate-900">{{ $calonSiswa->nik ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Nomor KK</dt><dd class="font-semibold text-slate-900">{{ $calonSiswa->no_kk ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Tempat / Tanggal Lahir</dt><dd class="text-slate-800">{{ $calonSiswa->tempat_lahir }}, {{ $calonSiswa->tanggal_lahir->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($calonSiswa->tanggal_lahir)->age }} tahun)</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Jenis Kelamin</dt><dd class="text-slate-800">{{ $calonSiswa->jenis_kelamin === 'L' ? 'Laki-laki' : ($calonSiswa->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Asal TK / Sekolah</dt><dd class="text-slate-800">{{ $calonSiswa->asal_tk ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Status Anak</dt><dd class="text-slate-800">Anak ke-{{ $calonSiswa->anak_ke ?: '-' }} dari {{ $calonSiswa->jumlah_saudara ?: '-' }} bersaudara</dd></div>
                    </dl>
                </div>

                <!-- Bagian Alamat -->
                <div class="mt-5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded">2. Tempat Tinggal</h3>
                    <dl class="mt-3 grid gap-3 sm:grid-cols-2 text-sm">
                        <div class="sm:col-span-2"><dt class="text-xs font-bold text-slate-500 uppercase">Alamat Lengkap</dt><dd class="text-slate-800">{{ $calonSiswa->alamat_lengkap ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">RT / RW</dt><dd class="text-slate-800">{{ $calonSiswa->rt_rw ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Kelurahan / Desa</dt><dd class="text-slate-800">{{ $calonSiswa->kelurahan_desa ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Kecamatan</dt><dd class="text-slate-800">{{ $calonSiswa->kecamatan ?: '-' }}</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Kota / Kabupaten</dt><dd class="text-slate-800">{{ $calonSiswa->kota_kabupaten ?: '-' }}</dd></div>
                    </dl>
                </div>

                <!-- Bagian Orang Tua / Wali -->
                <div class="mt-5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded">3. Data Orang Tua / Wali</h3>
                    <div class="mt-3 grid gap-4 sm:grid-cols-2 text-sm">
                        <!-- Ayah -->
                        <div class="rounded border border-slate-100 bg-slate-50 p-3">
                            <p class="font-bold text-xs uppercase text-slate-600 mb-1.5">Ayah Kandung</p>
                            <p class="font-semibold text-slate-900">{{ $calonSiswa->nama_ayah ?: '-' }}</p>
                            <p class="text-xs text-slate-600">NIK: {{ $calonSiswa->nik_ayah ?: '-' }}</p>
                            <p class="text-xs text-slate-600">Pekerjaan: {{ $calonSiswa->pekerjaan_ayah ?: '-' }} ({{ $calonSiswa->pendidikan_ayah ?: '-' }})</p>
                            <p class="text-xs text-slate-600">No. HP: {{ $calonSiswa->no_hp_ayah ?: '-' }}</p>
                        </div>
                        <!-- Ibu -->
                        <div class="rounded border border-slate-100 bg-slate-50 p-3">
                            <p class="font-bold text-xs uppercase text-slate-600 mb-1.5">Ibu Kandung</p>
                            <p class="font-semibold text-slate-900">{{ $calonSiswa->nama_ibu ?: '-' }}</p>
                            <p class="text-xs text-slate-600">NIK: {{ $calonSiswa->nik_ibu ?: '-' }}</p>
                            <p class="text-xs text-slate-600">Pekerjaan: {{ $calonSiswa->pekerjaan_ibu ?: '-' }} ({{ $calonSiswa->pendidikan_ibu ?: '-' }})</p>
                            <p class="text-xs text-slate-600">No. HP: {{ $calonSiswa->no_hp_ibu ?: '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bagian Program & Observasi -->
                <div class="mt-5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded">4. Peminatan & Keterangan Seleksi</h3>
                    <dl class="mt-3 grid gap-3 sm:grid-cols-2 text-sm">
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Program Diminati</dt><dd class="font-semibold text-emerald-800">{{ $calonSiswa->program_diminati ?? '-' }}</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Sumber Informasi</dt><dd class="text-slate-800">{{ $calonSiswa->sumber_informasi ?? '-' }}</dd></div>
                        <div class="sm:col-span-2"><dt class="text-xs font-bold text-slate-500 uppercase">Alasan Memilih</dt><dd class="text-slate-800">{{ $calonSiswa->alasan_memilih ?? '-' }}</dd></div>
                        <div class="sm:col-span-2"><dt class="text-xs font-bold text-slate-500 uppercase">Catatan Admin</dt><dd class="text-slate-800">{{ $calonSiswa->catatan_admin ?? '-' }}</dd></div>
                        <div><dt class="text-xs font-bold text-slate-500 uppercase">Jadwal Observasi</dt><dd class="font-semibold text-slate-800">{{ $calonSiswa->jadwal_observasi?->format('d/m/Y H:i') ?? '-' }}</dd></div>
                    </dl>
                </div>
            </div>

            @if (auth()->user()->isAdmin())
                <div class="panel p-6">
                    <h2 class="text-lg font-bold text-slate-900">Validasi & Status Pendaftaran (Admin)</h2>
                    <p class="mt-1 text-sm text-slate-500">Ubah status pendaftaran calon siswa di sini. Jika diubah menjadi <strong>Diterima</strong>, surat pemberitahuan penerimaan dapat langsung dicetak oleh admin dan orang tua.</p>

                    <form method="POST" action="{{ route('pendaftaran.status', $calonSiswa) }}" class="mt-4 space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="label-modern">Status Pendaftaran</label>
                            <select name="status_pendaftaran" class="input-modern">
                                @include('pendaftaran.partials.status-options', ['selected' => $calonSiswa->status_pendaftaran])
                            </select>
                        </div>

                        <div>
                            <label class="label-modern">Jadwal Observasi</label>
                            <input type="datetime-local" name="jadwal_observasi" value="{{ $calonSiswa->jadwal_observasi?->format('Y-m-d\TH:i') }}" class="input-modern">
                        </div>

                        <div>
                            <label class="label-modern">Catatan untuk Orang Tua / Pengumuman</label>
                            <textarea name="catatan_admin" rows="3" class="input-modern" placeholder="Tuliskan catatan hasil validasi, persyaratan daftar ulang, atau keterangan lainnya...">{{ $calonSiswa->catatan_admin }}</textarea>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <button class="btn-primary">Perbarui Status</button>
                            @if (in_array($calonSiswa->status_pendaftaran, ['diterima', 'daftar_ulang']))
                                <a href="{{ route('pendaftaran.cetak-pemberitahuan', $calonSiswa) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 hover:underline">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    Cetak Surat Diterima (PDF)
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            @endif

            <div class="panel p-6">
                <h2 class="text-lg font-bold text-slate-900">Berkas Pendaftaran</h2>

                @if (! auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('pendaftaran.berkas.store', $calonSiswa) }}" enctype="multipart/form-data" class="mt-4 grid gap-3 sm:grid-cols-[1fr_1fr_auto]">
                        @csrf
                        <select name="jenis_berkas" class="input-modern" required>
                            <option value="">Pilih jenis berkas</option>
                            @foreach (['Akta Kelahiran', 'Kartu Keluarga', 'Pas Foto', 'Ijazah TK', 'Bukti Pembayaran'] as $jenis)
                                <option value="{{ $jenis }}">{{ $jenis }}</option>
                            @endforeach
                        </select>
                        <input type="file" name="file" class="input-modern" required>
                        <button class="btn-primary">Upload</button>
                    </form>
                @endif

                <div class="mt-5 space-y-3">
                    @forelse ($calonSiswa->berkas as $berkas)
                        <div class="rounded-lg border border-emerald-100 p-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $berkas->jenis_berkas }}</p>
                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($berkas->file_path) }}" target="_blank" class="mt-1 inline-flex text-sm font-semibold text-emerald-700">Lihat file</a>
                                    <p class="mt-1 text-sm text-slate-500">{{ $berkas->catatan ?? 'Belum ada catatan.' }}</p>
                                </div>
                                <span class="{{ $berkas->status === 'lengkap' ? 'badge-success' : ($berkas->status === 'revisi' ? 'badge-danger' : 'badge-warning') }}">{{ ucfirst($berkas->status) }}</span>
                            </div>

                            @if (auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('berkas.update', $berkas) }}" class="mt-3 grid gap-2 sm:grid-cols-[160px_1fr_auto]">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="input-modern !py-2">
                                        @foreach (['menunggu' => 'Menunggu', 'lengkap' => 'Lengkap', 'revisi' => 'Revisi'] as $value => $label)
                                            <option value="{{ $value }}" @selected($berkas->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <input name="catatan" value="{{ $berkas->catatan }}" class="input-modern !py-2" placeholder="Catatan berkas">
                                    <button class="btn-primary !py-2">Simpan</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada berkas diunggah.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="panel p-6">
            <h2 class="text-lg font-bold text-slate-900">Komunikasi Pendaftaran</h2>
            <div class="mt-5 max-h-[520px] space-y-3 overflow-y-auto pr-1">
                @forelse ($calonSiswa->pesan as $pesan)
                    <div class="rounded-lg {{ $pesan->user_id === auth()->id() ? 'bg-emerald-50' : 'bg-slate-50' }} p-4">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-bold text-slate-900">{{ $pesan->user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $pesan->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <p class="mt-2 text-sm leading-6 text-slate-700">{{ $pesan->pesan }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada pesan.</p>
                @endforelse
            </div>

            <form method="POST" action="{{ auth()->user()->isAdmin() ? route('pendaftaran.pesan.admin', $calonSiswa) : route('pendaftaran.pesan.store', $calonSiswa) }}" class="mt-5">
                @csrf
                <textarea name="pesan" rows="4" class="input-modern" placeholder="Tulis pesan untuk komunikasi PPDB..." required></textarea>
                <button class="btn-primary mt-3 w-full">Kirim Pesan</button>
            </form>
        </div>
    </div>
</x-app-layout>
