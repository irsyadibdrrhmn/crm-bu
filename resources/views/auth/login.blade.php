<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login PPDB SDIT Binaul Ummah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-emerald-50 via-white to-sky-50 p-4">
    <div class="grid w-full max-w-5xl overflow-hidden rounded-lg bg-white shadow-xl md:grid-cols-2">
        <div class="bg-gradient-to-br from-emerald-700 to-sky-800 p-10 text-white">
            <p class="text-sm font-bold uppercase tracking-[0.25em] text-emerald-100">PPDB Online</p>
            <h1 class="mt-4 text-3xl font-extrabold">SDIT Binaul Ummah</h1>
            <p class="mt-4 leading-7 text-emerald-50/90">Masuk untuk mengelola pendaftaran siswa baru, memantau status validasi, dan membaca pengumuman sekolah.</p>
        </div>
        <div class="bg-white p-10">
            <h2 class="mb-6 text-2xl font-bold text-emerald-800">Masuk ke Dashboard</h2>
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="label-modern">Email</label>
                    <input id="email" class="input-modern" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <label for="password" class="label-modern">Kata Sandi</label>
                    <input id="password" class="input-modern" type="password" name="password" required>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-emerald-200 text-emerald-600 focus:ring-emerald-500">
                    Ingat saya
                </label>
                <button class="btn-primary w-full">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
