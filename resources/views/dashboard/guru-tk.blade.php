<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Dashboard Guru TK / Mitra PPDB</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900">{{ auth()->user()->asal_sekolah ?: auth()->user()->name }}</h1>
            </div>
            <a href="{{ route('pendaftaran.create') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Daftarkan Siswa Baru
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <!-- Banner Info Guru TK -->
        <div class="rounded-xl border border-emerald-200 bg-gradient-to-r from-emerald-600 to-sky-700 p-6 text-white shadow-md">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="inline-flex rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white">Akun Kolektif / Rekomendasi TK</span>
                    <h2 class="mt-2 text-xl font-bold">Portal Pendaftaran Siswa Mitra: {{ auth()->user()->name }}</h2>
                    <p class="mt-1 text-sm text-emerald-100">
                        Anda dapat mendaftarkan murid-murid dari <strong>{{ auth()->user()->asal_sekolah ?: 'sekolah Anda' }}</strong>, mengunggah berkas, memantau hasil seleksi, dan mencetak dokumen resmi PPDB.
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('pendaftaran.create') }}" class="btn bg-white text-emerald-800 hover:bg-emerald-50">
                        + Tambah Pendaftaran Siswa
                    </a>
                </div>
            </div>
        </div>

        <!-- Ringkasan Metrik Guru TK -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Siswa Didaftarkan</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $calonSiswas->count() }}</p>
            </div>
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Dalam Proses</p>
                <p class="mt-2 text-3xl font-bold text-amber-600">{{ $calonSiswas->whereIn('status_pendaftaran', ['terkirim', 'diverifikasi', 'observasi'])->count() }}</p>
            </div>
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Dinyatakan Diterima</p>
                <p class="mt-2 text-3xl font-bold text-emerald-700">{{ $calonSiswas->where('status_pendaftaran', 'diterima')->count() }}</p>
            </div>
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Sudah Daftar Ulang</p>
                <p class="mt-2 text-3xl font-bold text-sky-700">{{ $calonSiswas->where('status_pendaftaran', 'daftar_ulang')->count() }}</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.3fr_0.7fr]">
            <!-- Daftar Siswa yang Didaftarkan -->
            <div class="panel p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-emerald-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Daftar Siswa Binaan TK</h2>
                        <p class="text-sm text-slate-500">Pantau proses observasi dan kelulusan anak binaan Anda.</p>
                    </div>
                    <span class="badge-primary">{{ $calonSiswas->count() }} Terdaftar</span>
                </div>

                <div class="mt-5 space-y-4">
                    @forelse ($calonSiswas as $siswa)
                        <div class="rounded-lg border border-emerald-100 bg-emerald-50/40 p-4 transition hover:bg-emerald-50/70">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="text-base font-bold text-slate-900">{{ $siswa->nama_lengkap }}</p>
                                        @if ($siswa->jenis_kelamin)
                                            <span class="rounded bg-slate-200 px-1.5 py-0.5 text-[10px] font-bold text-slate-700">
                                                {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-xs text-slate-600">
                                        NIK: <strong>{{ $siswa->nik ?: '-' }}</strong> &bull;
                                        TTL: {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir->translatedFormat('d F Y') }}
                                    </p>
                                    <p class="text-xs text-slate-600">
                                        Program: <span class="font-semibold text-emerald-800">{{ $siswa->program_diminati ?: '-' }}</span> &bull;
                                        Orang Tua: {{ $siswa->nama_ayah ?: ($siswa->nama_ibu ?: '-') }}
                                    </p>
                                </div>
                                <div>
                                    @include('pendaftaran.partials.status-badge', ['status' => $siswa->status_pendaftaran])
                                </div>
                            </div>

                            @if (in_array($siswa->status_pendaftaran, ['diterima', 'daftar_ulang']))
                                <div class="mt-3 rounded-lg border border-emerald-300 bg-emerald-100/80 p-2.5 text-xs text-emerald-950">
                                    <span class="font-bold">Alhamdulillah!</span> Siswa telah <strong>DITERIMA</strong> di SDIT Binaul Ummah. Surat keputusan penerimaan siap dicetak.
                                </div>
                            @endif

                            <div class="mt-3 flex flex-wrap items-center gap-2 pt-2 border-t border-emerald-100">
                                <a href="{{ route('pendaftaran.detail', $siswa) }}" class="btn-light !py-1.5 text-xs font-semibold">Detail & Berkas</a>
                                <a href="{{ route('pendaftaran.cetak-formulir', $siswa) }}" target="_blank" class="btn-secondary !py-1.5 inline-flex items-center gap-1 text-xs font-semibold">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    Formulir PDF
                                </a>
                                @if (in_array($siswa->status_pendaftaran, ['diterima', 'daftar_ulang']))
                                    <a href="{{ route('pendaftaran.cetak-pemberitahuan', $siswa) }}" target="_blank" class="btn-primary !py-1.5 inline-flex items-center gap-1 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Surat Diterima PDF
                                    </a>
                                @endif
                                @if ($siswa->jadwal_observasi)
                                    <span class="badge-primary !py-1 text-xs">Observasi: {{ $siswa->jadwal_observasi->format('d/m/Y H:i') }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-emerald-200 p-8 text-center">
                            <p class="font-semibold text-slate-700">Belum ada murid yang didaftarkan dari TK Anda.</p>
                            <p class="mt-1 text-sm text-slate-500">Klik tombol di bawah untuk mendaftarkan calon siswa baru.</p>
                            <a href="{{ route('pendaftaran.create') }}" class="btn-primary mt-4 inline-flex items-center gap-2">
                                + Daftarkan Siswa Sekarang
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Panel Samping: Jadwal & Pengumuman -->
            <div class="space-y-6">
                <div class="panel p-6">
                    <h2 class="text-lg font-bold text-slate-900">Jadwal PPDB</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($jadwals as $jadwal)
                            <div class="border-b border-emerald-100 pb-3 last:border-0 last:pb-0">
                                <p class="font-bold text-slate-900 text-sm">{{ $jadwal->tahapan }}</p>
                                <p class="mt-0.5 text-xs text-emerald-700 font-semibold">
                                    {{ $jadwal->tanggal_mulai->format('d/m/Y') }}
                                    @if ($jadwal->tanggal_selesai)
                                        - {{ $jadwal->tanggal_selesai->format('d/m/Y') }}
                                    @endif
                                </p>
                                <p class="mt-1 text-xs text-slate-600">{{ $jadwal->keterangan }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Jadwal PPDB belum tersedia.</p>
                        @endforelse
                    </div>
                </div>

                <div class="panel p-6">
                    <h2 class="text-lg font-bold text-slate-900">Pengumuman Sekolah</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($pengumumans as $pengumuman)
                            <article class="border-b border-emerald-100 pb-3 last:border-0 last:pb-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-emerald-700">{{ $pengumuman->tanggal_publish->translatedFormat('d F Y') }}</p>
                                <h3 class="mt-0.5 font-bold text-slate-900 text-sm">{{ $pengumuman->judul }}</h3>
                                <p class="mt-1 text-xs leading-5 text-slate-600">{{ Str::limit($pengumuman->konten, 130) }}</p>
                            </article>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada pengumuman.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

