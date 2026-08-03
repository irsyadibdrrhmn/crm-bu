<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Detail Pendaftaran</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">{{ $calonSiswa->nama_lengkap }}</h1>
        </div>
    </x-slot>

    <div class="grid gap-6 xl:grid-cols-[1fr_0.9fr]">
        <div class="space-y-6">
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="panel p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Biodata Calon Siswa</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $calonSiswa->orangTua->name }} - {{ $calonSiswa->orangTua->email }}</p>
                    </div>
                    @include('pendaftaran.partials.status-badge', ['status' => $calonSiswa->status_pendaftaran])
                </div>

                <dl class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div><dt class="text-xs font-bold uppercase text-slate-500">Tempat/Tanggal Lahir</dt><dd class="mt-1 text-sm text-slate-800">{{ $calonSiswa->tempat_lahir }}, {{ $calonSiswa->tanggal_lahir->format('d/m/Y') }}</dd></div>
                    <div><dt class="text-xs font-bold uppercase text-slate-500">Asal TK</dt><dd class="mt-1 text-sm text-slate-800">{{ $calonSiswa->asal_tk ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-bold uppercase text-slate-500">Sumber Informasi</dt><dd class="mt-1 text-sm text-slate-800">{{ $calonSiswa->sumber_informasi ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-bold uppercase text-slate-500">Program Diminati</dt><dd class="mt-1 text-sm text-slate-800">{{ $calonSiswa->program_diminati ?? '-' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-xs font-bold uppercase text-slate-500">Alasan Memilih</dt><dd class="mt-1 text-sm leading-6 text-slate-800">{{ $calonSiswa->alasan_memilih ?? '-' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-xs font-bold uppercase text-slate-500">Catatan Admin</dt><dd class="mt-1 text-sm leading-6 text-slate-800">{{ $calonSiswa->catatan_admin ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-bold uppercase text-slate-500">Jadwal Observasi</dt><dd class="mt-1 text-sm text-slate-800">{{ $calonSiswa->jadwal_observasi?->format('d/m/Y H:i') ?? '-' }}</dd></div>
                </dl>
            </div>

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
