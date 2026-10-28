<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran - {{ $calonSiswa->nama_lengkap }}</title>
    <style>
        @page {
            margin: 12mm 15mm 12mm 15mm;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            font-size: 9pt;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-box {
            width: 54px;
            height: 54px;
            background-color: #047857;
            color: #ffffff;
            font-weight: bold;
            font-size: 16pt;
            text-align: center;
            line-height: 54px;
            border-radius: 6px;
        }
        .school-name {
            font-size: 14pt;
            font-weight: bold;
            color: #064e3b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .school-tagline {
            font-size: 9pt;
            font-weight: bold;
            color: #047857;
            margin: 1px 0 0 0;
        }
        .school-contact {
            font-size: 7.5pt;
            color: #64748b;
            margin: 2px 0 0 0;
        }
        .divider {
            border-top: 2px solid #0f172a;
            border-bottom: 1px solid #0f172a;
            height: 2px;
            margin-top: 4px;
            margin-bottom: 10px;
        }
        .title-box {
            text-align: center;
            margin-bottom: 10px;
        }
        .title-box h1 {
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .title-box p {
            font-size: 8.5pt;
            color: #475569;
            margin: 1px 0 0 0;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            margin-bottom: 10px;
        }
        .meta-table td {
            padding: 5px 8px;
            font-size: 8.5pt;
        }
        .section-title {
            background-color: #ecfdf5;
            color: #065f46;
            font-weight: bold;
            font-size: 8.5pt;
            padding: 4px 8px;
            border-left: 3px solid #059669;
            margin-top: 8px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .data-table td {
            padding: 3px 5px;
            font-size: 8.5pt;
            vertical-align: top;
        }
        .data-table td.label {
            width: 30%;
            color: #475569;
            font-weight: normal;
        }
        .data-table td.separator {
            width: 3%;
            text-align: center;
            color: #64748b;
        }
        .data-table td.value {
            width: 67%;
            font-weight: bold;
            color: #0f172a;
        }
        .sub-box {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            margin-bottom: 6px;
            border: 1px solid #e2e8f0;
            background-color: #fcfcfc;
        }
        .sub-box th {
            background-color: #f1f5f9;
            color: #334155;
            font-size: 8pt;
            text-transform: uppercase;
            padding: 4px 6px;
            text-align: left;
            border-bottom: 1px solid #cbd5e1;
        }
        .sub-box td {
            padding: 3px 6px;
            font-size: 8pt;
            border-bottom: 1px solid #f1f5f9;
        }
        .table-berkas {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            margin-bottom: 8px;
        }
        .table-berkas th {
            background-color: #f1f5f9;
            color: #334155;
            font-size: 8pt;
            text-transform: uppercase;
            padding: 4px 6px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }
        .table-berkas td {
            font-size: 8pt;
            padding: 3px 6px;
            border: 1px solid #e2e8f0;
            color: #1e293b;
        }
        .status-badge {
            display: inline-block;
            padding: 1px 5px;
            border-radius: 3px;
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-lengkap { background-color: #d1fae5; color: #065f46; }
        .status-menunggu { background-color: #fef3c7; color: #92400e; }
        .status-revisi { background-color: #ffe4e6; color: #9f1239; }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 8.5pt;
        }
        .signature-space {
            height: 48px;
        }
        .footer-note {
            margin-top: 10px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 4px;
            font-size: 7pt;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 60px; text-align: left;">
                <div class="logo-box">BU</div>
            </td>
            <td style="text-align: center;">
                <h2 class="school-name">{{ $profil['nama_sekolah'] ?? 'SDIT BINAUL UMMAH' }}</h2>
                <p class="school-tagline">{{ $profil['tagline'] ?? 'Belajar, Berkarakter, dan Bertumbuh Bersama' }}</p>
                <p class="school-contact">Penerimaan Peserta Didik Baru (PPDB) &bull; {{ $profil['kontak'] ?? 'Panitia PPDB SDIT Binaul Ummah' }}</p>
            </td>
            <td style="width: 60px;"></td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="title-box">
        <h1>Formulir Pendaftaran Calon Siswa Baru</h1>
        <p>Tahun Pelajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 50%;"><strong>No. Registrasi:</strong> REG-{{ str_pad($calonSiswa->id, 5, '0', STR_PAD_LEFT) }}</td>
            <td style="width: 50%; text-align: right;"><strong>Tanggal Daftar:</strong> {{ $calonSiswa->created_at->locale('id')->translatedFormat('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td><strong>Status Pendaftaran:</strong> {{ strtoupper(str_replace('_', ' ', $calonSiswa->status_pendaftaran)) }}</td>
            <td style="text-align: right;"><strong>Pendaftar:</strong> {{ $calonSiswa->pendaftar_peran === 'guru_tk' ? 'Guru TK Mitra' : 'Orang Tua' }} ({{ $calonSiswa->orangTua->name }})</td>
        </tr>
    </table>

    <div class="section-title">A. Data Calon Siswa</div>
    <table class="data-table">
        <tr>
            <td class="label">Nama Lengkap Anak</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label">NIK Calon Siswa</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->nik ?: '-' }} &nbsp;&nbsp;&nbsp;&nbsp; <strong>No. KK:</strong> {{ $calonSiswa->no_kk ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tempat, Tanggal Lahir</td>
            <td class="separator">:</td>
            <td class="value">
                {{ $calonSiswa->tempat_lahir }}, {{ $calonSiswa->tanggal_lahir->locale('id')->translatedFormat('d F Y') }}
                <span style="font-weight: normal; color: #64748b;">({{ \Carbon\Carbon::parse($calonSiswa->tanggal_lahir)->age }} tahun)</span>
            </td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->jenis_kelamin === 'L' ? 'Laki-laki' : ($calonSiswa->jenis_kelamin === 'P' ? 'Perempuan' : '-') }} &nbsp;&nbsp;&nbsp;&nbsp; <strong>Status Anak:</strong> Anak ke-{{ $calonSiswa->anak_ke ?: '-' }} dari {{ $calonSiswa->jumlah_saudara ?: '-' }} bersaudara</td>
        </tr>
        <tr>
            <td class="label">Asal TK / RA / PAUD</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->asal_tk ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Tempat Tinggal</td>
            <td class="separator">:</td>
            <td class="value">
                {{ $calonSiswa->alamat_lengkap ?: '-' }}
                @if ($calonSiswa->rt_rw) RT/RW {{ $calonSiswa->rt_rw }} @endif
                @if ($calonSiswa->kelurahan_desa) Kel. {{ $calonSiswa->kelurahan_desa }} @endif
                @if ($calonSiswa->kecamatan) Kec. {{ $calonSiswa->kecamatan }} @endif
                @if ($calonSiswa->kota_kabupaten) {{ $calonSiswa->kota_kabupaten }} @endif
            </td>
        </tr>
    </table>

    <div class="section-title">B. Data Orang Tua / Wali</div>
    <table class="sub-box">
        <thead>
            <tr>
                <th style="width: 25%;">Keterangan</th>
                <th style="width: 37%;">Data Ayah Kandung</th>
                <th style="width: 38%;">Data Ibu Kandung</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Nama Lengkap</strong></td>
                <td>{{ $calonSiswa->nama_ayah ?: '-' }}</td>
                <td>{{ $calonSiswa->nama_ibu ?: '-' }}</td>
            </tr>
            <tr>
                <td><strong>NIK (16 Digit)</strong></td>
                <td>{{ $calonSiswa->nik_ayah ?: '-' }}</td>
                <td>{{ $calonSiswa->nik_ibu ?: '-' }}</td>
            </tr>
            <tr>
                <td><strong>Pekerjaan</strong></td>
                <td>{{ $calonSiswa->pekerjaan_ayah ?: '-' }}</td>
                <td>{{ $calonSiswa->pekerjaan_ibu ?: '-' }}</td>
            </tr>
            <tr>
                <td><strong>Pendidikan</strong></td>
                <td>{{ $calonSiswa->pendidikan_ayah ?: '-' }}</td>
                <td>{{ $calonSiswa->pendidikan_ibu ?: '-' }}</td>
            </tr>
            <tr>
                <td><strong>No. WhatsApp/HP</strong></td>
                <td>{{ $calonSiswa->no_hp_ayah ?: '-' }}</td>
                <td>{{ $calonSiswa->no_hp_ibu ?: '-' }}</td>
            </tr>
        </tbody>
    </table>

    @if ($calonSiswa->nama_wali)
        <table class="data-table" style="margin-top: 2px;">
            <tr>
                <td class="label">Data Wali Siswa</td>
                <td class="separator">:</td>
                <td class="value" style="font-weight: normal;">
                    <strong>{{ $calonSiswa->nama_wali }}</strong> ({{ $calonSiswa->pekerjaan_wali ?: 'Wali' }}) - HP: {{ $calonSiswa->no_hp_wali ?: '-' }}
                </td>
            </tr>
        </table>
    @endif

    <div class="section-title">C. Peminatan & Referensi</div>
    <table class="data-table">
        <tr>
            <td class="label">Program Pilihan</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->program_diminati ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Sumber Informasi</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->sumber_informasi ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Alasan Memilih Sekolah</td>
            <td class="separator">:</td>
            <td class="value" style="font-weight: normal;">{{ $calonSiswa->alasan_memilih ?: '-' }}</td>
        </tr>
    </table>

    <div class="section-title">D. Berkas Kelengkapan Pendaftaran</div>
    <table class="table-berkas">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Jenis Dokumen</th>
                <th style="width: 25%;">Status Verifikasi</th>
                <th style="width: 35%;">Catatan Panitia</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($calonSiswa->berkas as $index => $berkas)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td><strong>{{ $berkas->jenis_berkas }}</strong></td>
                    <td>
                        <span class="status-badge status-{{ $berkas->status }}">{{ ucfirst($berkas->status) }}</span>
                    </td>
                    <td>{{ $berkas->catatan ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #64748b; font-style: italic; padding: 6px;">
                        Belum ada dokumen digital yang diunggah. Silakan lengkapi berkas fisik saat observasi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($calonSiswa->jadwal_observasi || $calonSiswa->catatan_admin)
        <div class="section-title">E. Jadwal Observasi & Catatan Panitia</div>
        <table class="data-table">
            @if ($calonSiswa->jadwal_observasi)
                <tr>
                    <td class="label">Jadwal Observasi</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $calonSiswa->jadwal_observasi->locale('id')->translatedFormat('l, d F Y, H:i') }} WIB</td>
                </tr>
            @endif
            @if ($calonSiswa->catatan_admin)
                <tr>
                    <td class="label">Catatan Panitia PPDB</td>
                    <td class="separator">:</td>
                    <td class="value" style="font-weight: normal; color: #047857;">{{ $calonSiswa->catatan_admin }}</td>
                </tr>
            @endif
        </table>
    @endif

    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Panitia PPDB {{ $profil['nama_sekolah'] ?? 'SDIT Binaul Ummah' }}</strong>
                <div class="signature-space"></div>
                ( _________________________ )
            </td>
            <td>
                {{ $calonSiswa->kota_kabupaten ?? ($calonSiswa->tempat_lahir ?? 'Tempat') }}, {{ $calonSiswa->created_at->locale('id')->translatedFormat('d F Y') }}<br>
                Orang Tua / Wali / Pendaftar,
                <div class="signature-space"></div>
                <strong>( {{ $calonSiswa->nama_ayah ?: ($calonSiswa->nama_ibu ?: $calonSiswa->orangTua->name) }} )</strong>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Dokumen ini diterbitkan secara otomatis oleh Sistem PPDB Online {{ $profil['nama_sekolah'] ?? 'SDIT Binaul Ummah' }} sebagai bukti formulir pendaftaran resmi sesuai berkas fisik.
    </div>
</body>
</html>
