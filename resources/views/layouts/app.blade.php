<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CRM PPDB SDIT Binaul Ummah') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-emerald-50">
    <div class="app-shell min-h-screen">
        @include('layouts.navigation')
        <main class="lg:pl-72">
            @isset($header)
                <header class="topbar">
                    <div class="px-6 py-5 lg:px-10">{{ $header }}</div>
                </header>
            @endisset
            <section class="px-4 py-6 fade-in sm:px-6 lg:px-10 lg:py-8">
                {{ $slot }}
            </section>
        </main>
    </div>
</body>

</html>
