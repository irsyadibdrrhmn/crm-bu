<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Dashboard Orang Tua</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">Status Pendaftaran Anak</h1>
        </div>
    </x-slot>

    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="panel p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Data Calon Siswa</h2>
                        <p class="text-sm text-slate-500">Pantau hasil validasi pendaftaran dari sekolah.</p>
                    </div>
                    <a href="{{ route('pendaftaran.create') }}" class="btn-primary">Daftar Sekarang</a>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse ($calonSiswas as $siswa)
                        <div class="rounded-lg border border-emerald-100 bg-emerald-50/50 p-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $siswa->nama_lengkap }}</p>
                                    <p class="mt-1 text-sm text-slate-600">{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir->translatedFormat('d F Y') }}</p>
                                    <p class="text-sm text-slate-600">Asal TK: {{ $siswa->asal_tk ?? '-' }}</p>
                                </div>
                                @include('pendaftaran.partials.status-badge', ['status' => $siswa->status_pendaftaran])
                            </div>

                            @if (in_array($siswa->status_pendaftaran, ['diterima', 'daftar_ulang']))
                                <div class="mt-3 rounded-lg border border-emerald-300 bg-emerald-100/80 p-3 text-emerald-950">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-5 w-5 text-emerald-700 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        <span class="text-sm font-bold">Alhamdulillah! Ananda dinyatakan DITERIMA di SDIT Binaul Ummah.</span>
                                    </div>
                                    <p class="mt-1 text-xs text-emerald-800">Surat pemberitahuan penerimaan resmi telah diterbitkan dan dapat Anda cetak sebagai dokumen kelulusan seleksi PPDB.</p>
                                </div>
                            @endif

                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                <a href="{{ route('pendaftaran.detail', $siswa) }}" class="btn-light !py-2">Detail & Berkas</a>
                                <a href="{{ route('pendaftaran.cetak-formulir', $siswa) }}" target="_blank" class="btn-secondary !py-2 inline-flex items-center gap-1.5 text-xs font-semibold">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    Cetak Formulir (PDF)
                                </a>
                                @if (in_array($siswa->status_pendaftaran, ['diterima', 'daftar_ulang']))
                                    <a href="{{ route('pendaftaran.cetak-pemberitahuan', $siswa) }}" target="_blank" class="btn-primary !py-2 inline-flex items-center gap-1.5 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Cetak Surat Diterima (PDF)
                                    </a>
                                @endif
                                @if ($siswa->jadwal_observasi)
                                    <span class="badge-primary">Observasi: {{ $siswa->jadwal_observasi->format('d/m/Y H:i') }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-emerald-200 p-6 text-center">
                            <p class="font-semibold text-slate-700">Belum ada data pendaftaran.</p>
                            <p class="mt-1 text-sm text-slate-500">Silakan isi formulir calon siswa baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="panel p-6">
            <h2 class="text-lg font-bold text-slate-900">Jadwal PPDB</h2>
            <div class="mt-5 space-y-4">
                @forelse ($jadwals as $jadwal)
                    <div class="border-b border-emerald-100 pb-4 last:border-0 last:pb-0">
                        <p class="font-bold text-slate-900">{{ $jadwal->tahapan }}</p>
                        <p class="mt-1 text-sm text-emerald-700">
                            {{ $jadwal->tanggal_mulai->format('d/m/Y') }}
                            @if ($jadwal->tanggal_selesai)
                                - {{ $jadwal->tanggal_selesai->format('d/m/Y') }}
                            @endif
                        </p>
                        <p class="mt-1 text-sm text-slate-600">{{ $jadwal->keterangan }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Jadwal PPDB belum tersedia.</p>
                @endforelse
            </div>
        </div>

        <div class="panel p-6 xl:col-start-2">
            <h2 class="text-lg font-bold text-slate-900">Pengumuman Terbaru</h2>
            <div class="mt-5 space-y-4">
                @forelse ($pengumumans as $pengumuman)
                    <article class="border-b border-emerald-100 pb-4 last:border-0 last:pb-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700">{{ $pengumuman->tanggal_publish->translatedFormat('d F Y') }}</p>
                        <h3 class="mt-1 font-bold text-slate-900">{{ $pengumuman->judul }}</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ Str::limit($pengumuman->konten, 160) }}</p>
                    </article>
                @empty
                    <p class="text-sm text-slate-500">Belum ada pengumuman dari sekolah.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
