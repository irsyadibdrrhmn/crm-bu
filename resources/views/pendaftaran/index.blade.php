<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Admin PPDB</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">Data Pendaftar</h1>
        </div>
        <a href="{{ route('pendaftaran.export') }}" class="btn-primary">Export CSV</a>
    </x-slot>

    <div class="panel overflow-hidden">
        @if (session('success'))
            <div class="border-b border-emerald-100 bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Calon Siswa</th>
                        <th>Orang Tua</th>
                        <th>Tanggal Lahir</th>
                        <th>Asal TK</th>
                        <th>Berkas</th>
                        <th>Status</th>
                        <th>Validasi</th>
                        <th>Aksi / Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftar as $siswa)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-900">{{ $siswa->nama_lengkap }}</div>
                                <div class="text-[11px] text-slate-500">NIK: {{ $siswa->nik ?: '-' }} ({{ $siswa->jenis_kelamin === 'L' ? 'L' : ($siswa->jenis_kelamin === 'P' ? 'P' : '-') }})</div>
                            </td>
                            <td>
                                <div class="text-slate-900">{{ $siswa->orangTua->name }}</div>
                                @if ($siswa->pendaftar_peran === 'guru_tk' || $siswa->orangTua->role === 'guru_tk')
                                    <span class="inline-block mt-0.5 rounded bg-sky-100 px-1.5 py-0.5 text-[10px] font-bold text-sky-800">Guru TK Mitra</span>
                                @endif
                            </td>
                            <td>{{ $siswa->tanggal_lahir->format('d/m/Y') }}</td>
                            <td>{{ $siswa->asal_tk ?? '-' }}</td>
                            <td>{{ $siswa->berkas->where('status', 'lengkap')->count() }}/{{ $siswa->berkas->count() }} lengkap</td>
                            <td>@include('pendaftaran.partials.status-badge', ['status' => $siswa->status_pendaftaran])</td>
                            <td>
                                <form method="POST" action="{{ route('pendaftaran.status', $siswa) }}" class="grid min-w-80 gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status_pendaftaran" class="input-modern !py-2">
                                        @include('pendaftaran.partials.status-options', ['selected' => $siswa->status_pendaftaran])
                                    </select>
                                    <input type="datetime-local" name="jadwal_observasi" value="{{ $siswa->jadwal_observasi?->format('Y-m-d\TH:i') }}" class="input-modern !py-2">
                                    <textarea name="catatan_admin" rows="2" class="input-modern !py-2" placeholder="Catatan untuk orang tua">{{ $siswa->catatan_admin }}</textarea>
                                    <button class="btn-primary !py-2">Simpan</button>
                                </form>
                            </td>
                            <td>
                                <div class="flex flex-col gap-1.5 min-w-[130px]">
                                    <a href="{{ route('pendaftaran.show', $siswa) }}" class="btn-light !py-1.5 text-center text-xs">Detail</a>
                                    <a href="{{ route('pendaftaran.cetak-formulir', $siswa) }}" target="_blank" class="inline-flex items-center justify-center gap-1 text-xs font-semibold text-emerald-700 hover:text-emerald-800 hover:underline">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                        Formulir PDF
                                    </a>
                                    @if (in_array($siswa->status_pendaftaran, ['diterima', 'daftar_ulang']))
                                        <a href="{{ route('pendaftaran.cetak-pemberitahuan', $siswa) }}" target="_blank" class="inline-flex items-center justify-center gap-1 rounded bg-emerald-100 px-2 py-1 text-xs font-bold text-emerald-800 hover:bg-emerald-200">
                                            <svg class="h-3.5 w-3.5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            Surat Diterima PDF
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-slate-500">Belum ada data pendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-emerald-100 p-5">
            {{ $pendaftar->links() }}
        </div>
    </div>
</x-app-layout>
