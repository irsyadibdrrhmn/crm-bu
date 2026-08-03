@php
    $user = auth()->user();
    $navItems = $user?->role === 'admin'
        ? [
            ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'chart'],
            ['label' => 'Leads Orang Tua', 'route' => 'leads.index', 'active' => 'leads.*', 'icon' => 'users'],
            ['label' => 'Data Pendaftar', 'route' => 'pendaftaran.index', 'active' => 'pendaftaran.*', 'icon' => 'students'],
            ['label' => 'Profil Sekolah', 'route' => 'profil-sekolah.edit', 'active' => 'profil-sekolah.*', 'icon' => 'school'],
            ['label' => 'Jadwal PPDB', 'route' => 'jadwal-ppdb.index', 'active' => 'jadwal-ppdb.*', 'icon' => 'calendar'],
            ['label' => 'Pengumuman', 'route' => 'pengumuman.index', 'active' => 'pengumuman.*', 'icon' => 'megaphone'],
        ]
        : [
            ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'home'],
            ['label' => 'Daftar Anak', 'route' => 'pendaftaran.create', 'active' => 'pendaftaran.*', 'icon' => 'book'],
        ];
@endphp

@php
    $renderIcon = function ($icon) {
        $paths = [
            'chart' => '<path d="M4 19V5M4 19h16M9 16V9M14 16V7M19 16v-4" />',
            'users' => '<path d="M16 19c0-2.21-2.686-4-6-4s-6 1.79-6 4" /><path d="M10 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" /><path d="M20 18c0-1.657-1.79-3-4-3" /><path d="M16 11a3 3 0 0 0 0-6" />',
            'students' => '<path d="M12 14c3.314 0 6 1.343 6 3v2H6v-2c0-1.657 2.686-3 6-3Z" /><path d="M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />',
            'school' => '<path d="M4 21V9l8-5 8 5v12" /><path d="M9 21v-7h6v7" /><path d="M3 21h18" />',
            'calendar' => '<path d="M7 3v4M17 3v4M4 9h16M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1Z" />',
            'megaphone' => '<path d="M4 13h3l9 4V7l-9 4H4v2Z" /><path d="M7 13l1 6h3" />',
            'home' => '<path d="M4 11.5 12 5l8 6.5V20a1 1 0 0 1-1 1h-5v-6h-4v6H5a1 1 0 0 1-1-1v-8.5Z" />',
            'book' => '<path d="M5 5.5A2.5 2.5 0 0 1 7.5 3H20v16H7.5A2.5 2.5 0 0 0 5 21.5v-16Z" /><path d="M5 5.5v16" />',
        ];

        return '<svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'.$paths[$icon].'</svg>';
    };
@endphp

<aside class="fixed inset-y-0 left-0 z-40 hidden w-72 border-r border-emerald-900/20 bg-gradient-to-b from-emerald-700 to-sky-800 px-5 py-6 text-white shadow-2xl lg:flex lg:flex-col">
    <div class="mb-8">
        <p class="text-xs uppercase tracking-[0.25em] text-emerald-100">CRM PPDB</p>
        <h1 class="mt-2 text-xl font-bold leading-tight">SDIT Binaul Ummah</h1>
        <p class="mt-2 text-sm text-emerald-50/80">Kelola pendaftaran siswa baru dan pengumuman sekolah secara terpadu.</p>
    </div>

    <nav class="space-y-2">
        @foreach ($navItems as $item)
            @php($active = request()->routeIs($item['active']))
            <a href="{{ route($item['route']) }}" class="sidebar-link {{ $active ? 'sidebar-link-active' : '' }}">
                {!! $renderIcon($item['icon']) !!}
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-auto pt-10">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <p class="text-xs text-emerald-50/70">Masuk sebagai</p>
            <p class="text-sm font-semibold">{{ $user->name ?? 'Pengguna' }}</p>
            <p class="mt-1 text-xs capitalize text-emerald-50/70">{{ str_replace('_', ' ', $user->role ?? '') }}</p>
            <form class="mt-4" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-light w-full !border-white/20 !bg-white/10 !text-white hover:!bg-white/20">Logout</button>
            </form>
        </div>
    </div>
</aside>

<nav class="sticky top-0 z-40 border-b border-emerald-100 bg-white/90 px-4 py-3 backdrop-blur lg:hidden">
    <div class="flex items-center justify-between">
        <p class="font-semibold text-emerald-800">SDIT Binaul Ummah</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm font-semibold text-emerald-700">Logout</button>
        </form>
    </div>
    <div class="mt-3 flex flex-wrap gap-2">
        @foreach ($navItems as $item)
            @php($active = request()->routeIs($item['active']))
            <a href="{{ route($item['route']) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold {{ $active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </div>
</nav>
