<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Dashboard Admin</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">Penerimaan Siswa Baru</h1>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Pendaftar</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ number_format($totalPendaftar) }}</p>
            </div>
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Leads Orang Tua</p>
                <p class="mt-3 text-3xl font-bold text-sky-700">{{ number_format($totalLeads) }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ number_format($leadBaru) }} lead baru</p>
            </div>
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Dalam Proses</p>
                <p class="mt-3 text-3xl font-bold text-amber-600">{{ number_format($pending) }}</p>
            </div>
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Diterima</p>
                <p class="mt-3 text-3xl font-bold text-emerald-700">{{ number_format($diterima) }}</p>
            </div>
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Ditolak</p>
                <p class="mt-3 text-3xl font-bold text-rose-700">{{ number_format($ditolak) }}</p>
            </div>
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Observasi</p>
                <p class="mt-3 text-3xl font-bold text-sky-700">{{ number_format($observasi) }}</p>
            </div>
            <div class="panel p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Daftar Ulang</p>
                <p class="mt-3 text-3xl font-bold text-emerald-700">{{ number_format($daftarUlang) }}</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1fr_0.7fr]">
            <div class="panel overflow-hidden">
            <div class="flex flex-col gap-3 border-b border-emerald-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Pendaftar Terbaru</h2>
                    <p class="text-sm text-slate-500">Validasi status calon siswa dari tabel ini.</p>
                </div>
                <a href="{{ route('pendaftaran.index') }}" class="btn-primary">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Calon Siswa</th>
                            <th>Orang Tua</th>
                            <th>Asal TK</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftarTerbaru as $siswa)
                            <tr>
                                <td class="font-semibold text-slate-900">{{ $siswa->nama_lengkap }}</td>
                                <td>{{ $siswa->orangTua->name }}</td>
                                <td>{{ $siswa->asal_tk ?? '-' }}</td>
                                <td>
                                    @include('pendaftaran.partials.status-badge', ['status' => $siswa->status_pendaftaran])
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('pendaftaran.status', $siswa) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status_pendaftaran" class="input-modern !py-2">
                                            @include('pendaftaran.partials.status-options', ['selected' => $siswa->status_pendaftaran])
                                        </select>
                                        <button class="btn-primary !py-2">Simpan</button>
                                    </form>
                                    <div class="mt-2 flex flex-wrap items-center gap-2">
                                        <a href="{{ route('pendaftaran.show', $siswa) }}" class="inline-flex text-xs font-semibold text-emerald-700 hover:underline">Detail</a>
                                        <span class="text-slate-300">&bull;</span>
                                        <a href="{{ route('pendaftaran.cetak-formulir', $siswa) }}" target="_blank" class="inline-flex text-xs font-semibold text-slate-600 hover:text-emerald-700 hover:underline">Formulir PDF</a>
                                        @if (in_array($siswa->status_pendaftaran, ['diterima', 'daftar_ulang']))
                                            <span class="text-slate-300">&bull;</span>
                                            <a href="{{ route('pendaftaran.cetak-pemberitahuan', $siswa) }}" target="_blank" class="inline-flex items-center gap-1 rounded bg-emerald-100 px-2 py-0.5 text-xs font-bold text-emerald-800 hover:bg-emerald-200">
                                                Surat Diterima PDF
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-slate-500">Belum ada pendaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>

            <div class="panel p-6">
                <h2 class="text-lg font-bold text-slate-900">Sumber Informasi Efektif</h2>
                <div class="mt-4 space-y-3">
                    @forelse ($sumberPendaftar as $item)
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold text-slate-700">{{ $item->sumber }}</span>
                                <span class="text-slate-500">{{ $item->total }} pendaftar</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-emerald-50">
                                <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $totalPendaftar ? min(100, ($item->total / $totalPendaftar) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada data sumber informasi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
