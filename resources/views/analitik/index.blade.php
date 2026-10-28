<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Analitik CRM & PPDB</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900">Dashboard Analisis Penerimaan Siswa Baru</h1>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Data Real-Time CRM
                </span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- 1. KPI Metrik & Tingkat Konversi CRM -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="panel p-5 border-l-4 border-l-sky-500">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Leads (Prospek)</p>
                    <span class="rounded bg-sky-100 px-2 py-0.5 text-[11px] font-bold text-sky-800">Tahap 1</span>
                </div>
                <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ number_format($totalLeads) }}</p>
                <p class="mt-1 text-xs text-slate-500">Orang tua berminat / mengisi formulir minat.</p>
            </div>

            <div class="panel p-5 border-l-4 border-l-emerald-500">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Formulir Masuk</p>
                    <span class="rounded bg-emerald-100 px-2 py-0.5 text-[11px] font-bold text-emerald-800">{{ $rateLeadToRegister }}% dari Leads</span>
                </div>
                <p class="mt-2 text-3xl font-extrabold text-emerald-800">{{ number_format($totalPendaftar) }}</p>
                <p class="mt-1 text-xs text-slate-500">Calon siswa melengkapi formulir PPDB.</p>
            </div>

            <div class="panel p-5 border-l-4 border-l-amber-500">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Tingkat Penerimaan</p>
                    <span class="rounded bg-amber-100 px-2 py-0.5 text-[11px] font-bold text-amber-800">{{ $rateAcceptance }}% Lulus</span>
                </div>
                <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ number_format($totalDiterima) }} <span class="text-sm font-normal text-slate-500">siswa</span></p>
                <p class="mt-1 text-xs text-slate-500">{{ $totalDitolak }} calon siswa belum memenuhi kriteria.</p>
            </div>

            <div class="panel p-5 border-l-4 border-l-teal-600">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Closing (Daftar Ulang)</p>
                    <span class="rounded bg-teal-100 px-2 py-0.5 text-[11px] font-bold text-teal-800">{{ $rateEnrollment }}% Komitmen</span>
                </div>
                <p class="mt-2 text-3xl font-extrabold text-teal-800">{{ number_format($totalDaftarUlang) }} <span class="text-sm font-normal text-slate-500">siswa</span></p>
                <p class="mt-1 text-xs text-slate-500">Rasio akhir: {{ $rateOverall }}% dari seluruh leads.</p>
            </div>
        </div>

        <!-- 2. Corong Konversi CRM (Funnel Chart) & Tren Waktu -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Corong Konversi -->
            <div class="panel p-6">
                <div class="border-b border-emerald-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">Corong Konversi CRM PPDB (*Funnel Process*)</h2>
                    <p class="text-xs text-slate-500">Mengukur efektivitas tiap tahapan konversi calon siswa dari kontak awal hingga daftar ulang.</p>
                </div>
                <div class="mt-4">
                    <canvas id="chartFunnel" height="240"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-4 gap-2 border-t border-slate-100 pt-3 text-center">
                    <div class="rounded bg-slate-50 p-2">
                        <p class="text-[10px] font-semibold text-slate-500 uppercase">Leads &rarr; Daftar</p>
                        <p class="mt-0.5 text-sm font-bold text-slate-800">{{ $rateLeadToRegister }}%</p>
                    </div>
                    <div class="rounded bg-slate-50 p-2">
                        <p class="text-[10px] font-semibold text-slate-500 uppercase">Daftar &rarr; Observasi</p>
                        <p class="mt-0.5 text-sm font-bold text-slate-800">{{ $totalPendaftar > 0 ? round(($totalObservasi / $totalPendaftar) * 100, 1) : 0 }}%</p>
                    </div>
                    <div class="rounded bg-slate-50 p-2">
                        <p class="text-[10px] font-semibold text-slate-500 uppercase">Observasi &rarr; Terima</p>
                        <p class="mt-0.5 text-sm font-bold text-emerald-700">{{ $totalObservasi > 0 ? round(($totalDiterima / $totalObservasi) * 100, 1) : 0 }}%</p>
                    </div>
                    <div class="rounded bg-slate-50 p-2">
                        <p class="text-[10px] font-semibold text-slate-500 uppercase">Terima &rarr; Closing</p>
                        <p class="mt-0.5 text-sm font-bold text-teal-700">{{ $rateEnrollment }}%</p>
                    </div>
                </div>
            </div>

            <!-- Tren Pendaftaran Waktu -->
            <div class="panel p-6">
                <div class="border-b border-emerald-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">Tren Pendaftaran Calon Siswa</h2>
                    <p class="text-xs text-slate-500">Volume pertumbuhan pendaftaran siswa baru berdasarkan periode.</p>
                </div>
                <div class="mt-4">
                    <canvas id="chartTren" height="240"></canvas>
                </div>
                <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 text-xs text-slate-500">
                    <span>Total terdaftar: <strong>{{ $totalPendaftar }} siswa</strong></span>
                    <span>Status: Periode Pendaftaran Aktif</span>
                </div>
            </div>
        </div>

        <!-- 3. Analisis Feeder Schools (TK Mitra & Guru TK) & Saluran Marketing -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Analisis Sekolah Asal / TK Mitra -->
            <div class="panel p-6">
                <div class="flex items-center justify-between border-b border-emerald-100 pb-3">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Kontribusi Asal Sekolah (TK Mitra)</h2>
                        <p class="text-xs text-slate-500">TK penyumbang pendaftar terbanyak (*Feeder Schools Analysis*).</p>
                    </div>
                    <span class="rounded bg-sky-100 px-2 py-0.5 text-xs font-bold text-sky-800">{{ $totalAkunGuruTk }} Akun Guru TK</span>
                </div>

                <div class="mt-4">
                    <canvas id="chartTkMitra" height="200"></canvas>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-500 text-left">
                                <th class="py-2">Nama TK / Lembaga</th>
                                <th class="py-2 text-center">Pendaftar</th>
                                <th class="py-2 text-center">Diterima</th>
                                <th class="py-2 text-right">Rasio Kelulusan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($tkMitra as $tk)
                                <tr>
                                    <td class="py-2 font-semibold text-slate-900">{{ $tk->nama_tk }}</td>
                                    <td class="py-2 text-center font-bold text-slate-800">{{ $tk->total }}</td>
                                    <td class="py-2 text-center font-bold text-emerald-700">{{ $tk->total_diterima }}</td>
                                    <td class="py-2 text-right text-slate-600">
                                        {{ $tk->total > 0 ? round(($tk->total_diterima / $tk->total) * 100) : 0 }}%
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3 text-center text-slate-400">Belum ada data sekolah asal.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Efektivitas Saluran Promosi Marketing -->
            <div class="panel p-6">
                <div class="border-b border-emerald-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">Efektivitas Saluran Pemasaran (Marketing Channels)</h2>
                    <p class="text-xs text-slate-500">Korelasi sumber informasi terhadap rasio siswa yang akhirnya diterima.</p>
                </div>

                <div class="mt-4">
                    <canvas id="chartMarketing" height="200"></canvas>
                </div>

                <div class="mt-4 space-y-2.5">
                    @foreach ($sumberMarketing as $sumber)
                        <div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-semibold text-slate-700">{{ $sumber->sumber }}</span>
                                <span class="text-slate-500">{{ $sumber->total }} pendaftar ({{ $sumber->total_diterima }} diterima)</span>
                            </div>
                            <div class="mt-1 h-2 rounded-full bg-slate-100">
                                <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $totalPendaftar > 0 ? min(100, ($sumber->total / $totalPendaftar) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 4. Peminatan Program & Demografi Calon Siswa -->
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
            <!-- Peminatan Program -->
            <div class="panel p-6">
                <h2 class="text-base font-bold text-slate-900">Distribusi Program Diminati</h2>
                <p class="text-xs text-slate-500">Peminatan program unggulan oleh wali murid.</p>
                <div class="mt-4 flex justify-center">
                    <div style="width: 220px; height: 220px;">
                        <canvas id="chartProgram"></canvas>
                    </div>
                </div>
                <div class="mt-4 space-y-1.5 text-xs">
                    @foreach ($programPeminatan as $prog)
                        <div class="flex items-center justify-between text-slate-700">
                            <span>{{ $prog->program }}</span>
                            <span class="font-bold">{{ $prog->total }} siswa</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Demografi Jenis Kelamin -->
            <div class="panel p-6">
                <h2 class="text-base font-bold text-slate-900">Rasio Jenis Kelamin</h2>
                <p class="text-xs text-slate-500">Perbandingan gender calon peserta didik baru.</p>
                <div class="mt-4 flex justify-center">
                    <div style="width: 220px; height: 220px;">
                        <canvas id="chartGender"></canvas>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-2 text-center text-xs">
                    <div class="rounded bg-sky-50 p-2">
                        <p class="text-slate-500 font-semibold">Laki-laki</p>
                        <p class="mt-0.5 text-sm font-bold text-sky-800">{{ $genderLaki }} siswa</p>
                    </div>
                    <div class="rounded bg-rose-50 p-2">
                        <p class="text-slate-500 font-semibold">Perempuan</p>
                        <p class="mt-0.5 text-sm font-bold text-rose-800">{{ $genderPerempuan }} siswa</p>
                    </div>
                </div>
            </div>

            <!-- Peran Pendaftar: Guru TK vs Orang Tua Mandiri -->
            <div class="panel p-6 sm:col-span-2 xl:col-span-1">
                <h2 class="text-base font-bold text-slate-900">Kanal Pendaftaran</h2>
                <p class="text-xs text-slate-500">Proporsi pendaftaran mandiri vs kolektif Guru TK.</p>
                <div class="mt-4 flex justify-center">
                    <div style="width: 220px; height: 220px;">
                        <canvas id="chartKanal"></canvas>
                    </div>
                </div>
                <div class="mt-4 space-y-2 text-xs">
                    <div class="rounded-lg border border-sky-100 bg-sky-50/50 p-2.5 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-sky-900">Rekomendasi Guru TK</p>
                            <p class="text-[11px] text-sky-700">{{ $totalAkunGuruTk }} akun perwakilan TK aktif</p>
                        </div>
                        <span class="text-base font-bold text-sky-800">{{ $pendaftarGuruTk }}</span>
                    </div>
                    <div class="rounded-lg border border-emerald-100 bg-emerald-50/50 p-2.5 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-emerald-900">Orang Tua Mandiri</p>
                            <p class="text-[11px] text-emerald-700">Pendaftaran mandiri via website</p>
                        </div>
                        <span class="text-base font-bold text-emerald-800">{{ $pendaftarOrangTua }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Chart Funnel Konversi CRM
            new Chart(document.getElementById('chartFunnel'), {
                type: 'bar',
                data: {
                    labels: ['1. Leads Prospek', '2. Formulir Masuk', '3. Observasi', '4. Diterima', '5. Closing (Daftar Ulang)'],
                    datasets: [{
                        label: 'Jumlah Siswa / Prospek',
                        data: [{{ $totalLeads }}, {{ $totalPendaftar }}, {{ $totalObservasi }}, {{ $totalDiterima }}, {{ $totalDaftarUlang }}],
                        backgroundColor: [
                            '#0284c7', // Sky
                            '#059669', // Emerald
                            '#d97706', // Amber
                            '#10b981', // Light Emerald
                            '#0f766e', // Teal
                        ],
                        borderRadius: 6,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                        y: { grid: { display: false } }
                    }
                }
            });

            // 2. Chart Tren Pendaftaran Waktu
            new Chart(document.getElementById('chartTren'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($pendaftaranBulanan->pluck('bulan')) !!},
                    datasets: [{
                        label: 'Pendaftaran Siswa',
                        data: {!! json_encode($pendaftaranBulanan->pluck('total')) !!},
                        borderColor: '#059669',
                        backgroundColor: 'rgba(5, 150, 105, 0.1)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 5,
                        pointBackgroundColor: '#047857',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 3. Chart TK Mitra
            new Chart(document.getElementById('chartTkMitra'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($tkMitra->pluck('nama_tk')) !!},
                    datasets: [
                        {
                            label: 'Total Pendaftar',
                            data: {!! json_encode($tkMitra->pluck('total')) !!},
                            backgroundColor: '#0284c7',
                            borderRadius: 4,
                        },
                        {
                            label: 'Lulus Diterima',
                            data: {!! json_encode($tkMitra->pluck('total_diterima')) !!},
                            backgroundColor: '#10b981',
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 4. Chart Marketing Channels
            new Chart(document.getElementById('chartMarketing'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($sumberMarketing->pluck('sumber')) !!},
                    datasets: [{
                        label: 'Total Calon Siswa',
                        data: {!! json_encode($sumberMarketing->pluck('total')) !!},
                        backgroundColor: '#14b8a6',
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 5. Chart Program Diminati
            new Chart(document.getElementById('chartProgram'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($programPeminatan->pluck('program')) !!},
                    datasets: [{
                        data: {!! json_encode($programPeminatan->pluck('total')) !!},
                        backgroundColor: ['#059669', '#0284c7', '#d97706', '#8b5cf6', '#ec4899'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } }
                }
            });

            // 6. Chart Gender
            new Chart(document.getElementById('chartGender'), {
                type: 'pie',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [{{ $genderLaki }}, {{ $genderPerempuan }}],
                        backgroundColor: ['#0284c7', '#f43f5e'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } }
                }
            });

            // 7. Chart Kanal
            new Chart(document.getElementById('chartKanal'), {
                type: 'doughnut',
                data: {
                    labels: ['Rekomendasi Guru TK', 'Orang Tua Mandiri'],
                    datasets: [{
                        data: [{{ $pendaftarGuruTk }}, {{ $pendaftarOrangTua }}],
                        backgroundColor: ['#0284c7', '#059669'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } }
                }
            });
        });
    </script>
</x-app-layout>

