<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{ role: '{{ old('role', 'orang_tua') }}' }">
        @csrf

        <h1 class="mb-2 text-2xl font-bold text-emerald-800">Buat Akun PPDB</h1>
        <p class="mb-6 text-sm text-slate-500">Daftar sebagai Orang Tua atau Guru TK mitra untuk mendaftarkan calon siswa.</p>

        <!-- Pilihan Peran -->
        <div class="mb-5">
            <x-input-label :value="__('Daftar Sebagai')" class="mb-2" />
            <div class="grid grid-cols-2 gap-3">
                <label class="flex cursor-pointer items-center justify-center gap-2 rounded-lg border p-3 text-sm font-semibold transition"
                    :class="role === 'orang_tua' ? 'border-emerald-600 bg-emerald-50 text-emerald-800 ring-2 ring-emerald-500' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                    <input type="radio" name="role" value="orang_tua" x-model="role" class="hidden">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Orang Tua Siswa
                </label>
                <label class="flex cursor-pointer items-center justify-center gap-2 rounded-lg border p-3 text-sm font-semibold transition"
                    :class="role === 'guru_tk' ? 'border-emerald-600 bg-emerald-50 text-emerald-800 ring-2 ring-emerald-500' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                    <input type="radio" name="role" value="guru_tk" x-model="role" class="hidden">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    Guru TK / Mitra
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="name" x-text="role === 'guru_tk' ? 'Nama Lengkap Guru / Perwakilan TK' : 'Nama Lengkap Orang Tua'" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Kolom Khusus Guru TK -->
        <div x-show="role === 'guru_tk'" x-transition class="mt-4 space-y-4 rounded-lg border border-emerald-200 bg-emerald-50/50 p-4">
            <div>
                <x-input-label for="asal_sekolah" :value="__('Nama Asal TK / Sekolah Mitra')" />
                <x-text-input id="asal_sekolah" class="block mt-1 w-full" type="text" name="asal_sekolah" :value="old('asal_sekolah')" placeholder="Contoh: TK Al Ikhlas Bogor" />
                <x-input-error :messages="$errors->get('asal_sekolah')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="no_hp" :value="__('Nomor WhatsApp / HP Guru')" />
                <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp')" placeholder="08xxxxxxxxxx" />
                <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="rounded-md text-sm text-slate-600 underline hover:text-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
