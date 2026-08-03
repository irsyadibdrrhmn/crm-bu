<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Enhance</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">Jadwal PPDB</h1>
        </div>
    </x-slot>

    <div class="grid gap-6 xl:grid-cols-[0.8fr_1.2fr]">
        <form method="POST" action="{{ route('jadwal-ppdb.store') }}" class="panel p-6">
            @csrf
            <h2 class="text-lg font-bold text-slate-900">Tambah Tahapan</h2>
            <div class="mt-5 space-y-4">
                <div><label class="label-modern">Tahapan</label><input name="tahapan" class="input-modern" required></div>
                <div><label class="label-modern">Tanggal Mulai</label><input type="date" name="tanggal_mulai" class="input-modern" required></div>
                <div><label class="label-modern">Tanggal Selesai</label><input type="date" name="tanggal_selesai" class="input-modern"></div>
                <div><label class="label-modern">Urutan</label><input type="number" name="urutan" value="0" class="input-modern"></div>
                <div><label class="label-modern">Keterangan</label><textarea name="keterangan" rows="4" class="input-modern"></textarea></div>
                <button class="btn-primary w-full">Tambah Jadwal</button>
            </div>
        </form>

        <div class="panel overflow-hidden">
            @if (session('success'))
                <div class="border-b border-emerald-100 bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="divide-y divide-emerald-100">
                @forelse ($jadwals as $jadwal)
                    <form method="POST" action="{{ route('jadwal-ppdb.update', $jadwal) }}" class="grid gap-3 p-5 lg:grid-cols-[1fr_150px_150px_90px_auto]">
                        @csrf
                        @method('PATCH')
                        <div>
                            <input name="tahapan" value="{{ $jadwal->tahapan }}" class="input-modern !py-2" required>
                            <textarea name="keterangan" rows="2" class="input-modern mt-2 !py-2">{{ $jadwal->keterangan }}</textarea>
                        </div>
                        <input type="date" name="tanggal_mulai" value="{{ $jadwal->tanggal_mulai->format('Y-m-d') }}" class="input-modern !py-2" required>
                        <input type="date" name="tanggal_selesai" value="{{ $jadwal->tanggal_selesai?->format('Y-m-d') }}" class="input-modern !py-2">
                        <input type="number" name="urutan" value="{{ $jadwal->urutan }}" class="input-modern !py-2">
                        <div class="flex gap-2">
                            <button class="btn-primary !py-2">Simpan</button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('jadwal-ppdb.destroy', $jadwal) }}" class="px-5 pb-5" onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm font-semibold text-rose-700">Hapus</button>
                    </form>
                @empty
                    <div class="p-8 text-center text-sm text-slate-500">Belum ada jadwal PPDB.</div>
                @endforelse
            </div>

            <div class="border-t border-emerald-100 p-5">{{ $jadwals->links() }}</div>
        </div>
    </div>
</x-app-layout>
