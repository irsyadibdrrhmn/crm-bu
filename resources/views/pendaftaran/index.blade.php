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
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftar as $siswa)
                        <tr>
                            <td class="font-semibold text-slate-900">{{ $siswa->nama_lengkap }}</td>
                            <td>{{ $siswa->orangTua->name }}</td>
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
                            <td><a href="{{ route('pendaftaran.show', $siswa) }}" class="btn-light">Buka</a></td>
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
