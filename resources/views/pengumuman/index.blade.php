<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Informasi Sekolah</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900">Pengumuman</h1>
            </div>
            <a href="{{ route('pengumuman.create') }}" class="btn-primary">Buat Pengumuman</a>
        </div>
    </x-slot>

    <div class="panel overflow-hidden">
        @if (session('success'))
            <div class="border-b border-emerald-100 bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="divide-y divide-emerald-100">
            @forelse ($pengumumans as $pengumuman)
                <article class="p-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="max-w-3xl">
                            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700">{{ $pengumuman->tanggal_publish->translatedFormat('d F Y') }}</p>
                            <h2 class="mt-1 text-lg font-bold text-slate-900">{{ $pengumuman->judul }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $pengumuman->konten }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('pengumuman.edit', $pengumuman) }}" class="btn-light">Edit</a>
                            <form method="POST" action="{{ route('pengumuman.destroy', $pengumuman) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn bg-rose-600 text-white hover:bg-rose-700">Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="p-8 text-center text-sm text-slate-500">Belum ada pengumuman.</div>
            @endforelse
        </div>

        <div class="border-t border-emerald-100 p-5">
            {{ $pengumumans->links() }}
        </div>
    </div>
</x-app-layout>
