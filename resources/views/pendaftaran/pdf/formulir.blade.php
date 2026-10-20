<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran - {{ $calonSiswa->nama_lengkap }}</title>
    <style>
        @page {
            margin: 15mm 18mm 15mm 18mm;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            font-size: 10pt;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-box {
            width: 60px;
            height: 60px;
            background-color: #047857;
            color: #ffffff;
            font-weight: bold;
            font-size: 18pt;
            text-align: center;
            line-height: 60px;
            border-radius: 8px;
        }
        .school-name {
            font-size: 16pt;
            font-weight: bold;
            color: #064e3b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .school-tagline {
            font-size: 9.5pt;
            font-weight: bold;
            color: #047857;
            margin: 2px 0 0 0;
        }
        .school-contact {
            font-size: 8pt;
            color: #64748b;
            margin: 2px 0 0 0;
        }
        .divider {
            border-top: 2px solid #0f172a;
            border-bottom: 1px solid #0f172a;
            height: 2px;
            margin-top: 6px;
            margin-bottom: 14px;
        }
        .title-box {
            text-align: center;
            margin-bottom: 14px;
        }
        .title-box h1 {
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .title-box p {
            font-size: 9pt;
            color: #475569;
            margin: 2px 0 0 0;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            margin-bottom: 14px;
            border-radius: 4px;
        }
        .meta-table td {
            padding: 6px 10px;
            font-size: 9pt;
        }
        .section-title {
            background-color: #ecfdf5;
            color: #065f46;
            font-weight: bold;
            font-size: 9.5pt;
            padding: 5px 10px;
            border-left: 4px solid #059669;
            margin-top: 10px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .data-table td {
            padding: 4px 6px;
            font-size: 9.5pt;
            vertical-align: top;
        }
        .data-table td.label {
            width: 32%;
            color: #475569;
            font-weight: normal;
        }
        .data-table td.separator {
            width: 3%;
            text-align: center;
            color: #64748b;
        }
        .data-table td.value {
            width: 65%;
            font-weight: bold;
            color: #0f172a;
        }
        .table-berkas {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 10px;
        }
        .table-berkas th {
            background-color: #f1f5f9;
            color: #334155;
            font-size: 8.5pt;
            text-transform: uppercase;
            padding: 5px 8px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }
        .table-berkas td {
            font-size: 8.5pt;
            padding: 5px 8px;
            border: 1px solid #e2e8f0;
            color: #1e293b;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-lengkap {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-menunggu {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-revisi {
            background-color: #ffe4e6;
            color: #9f1239;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 9pt;
        }
        .signature-space {
            height: 55px;
        }
        .footer-note {
            margin-top: 14px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 6px;
            font-size: 7.5pt;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 70px; text-align: left;">
                <div class="logo-box">BU</div>
            </td>
            <td style="text-align: center;">
                <h2 class="school-name">{{ $profil['nama_sekolah'] ?? 'SDIT BINAUL UMMAH' }}</h2>
                <p class="school-tagline">{{ $profil['tagline'] ?? 'Belajar, Berkarakter, dan Bertumbuh Bersama' }}</p>
                <p class="school-contact">Penerimaan Peserta Didik Baru (PPDB) &bull; {{ $profil['kontak'] ?? 'Panitia PPDB SDIT Binaul Ummah' }}</p>
            </td>
            <td style="width: 70px;"></td>
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
            <td style="text-align: right;"><strong>Program Diminati:</strong> {{ $calonSiswa->program_diminati ?? 'Reguler' }}</td>
        </tr>
    </table>

    <div class="section-title">A. Data Calon Siswa</div>
    <table class="data-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->nama_lengkap }}</td>
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
            <td class="label">Asal TK / RA / PAUD</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->asal_tk ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Program Pilihan</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->program_diminati ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Alasan Memilih Sekolah</td>
            <td class="separator">:</td>
            <td class="value" style="font-weight: normal;">{{ $calonSiswa->alasan_memilih ?: '-' }}</td>
        </tr>
    </table>

    <div class="section-title">B. Data Orang Tua / Wali</div>
    <table class="data-table">
        <tr>
            <td class="label">Nama Orang Tua / Wali</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->orangTua->name }}</td>
        </tr>
        <tr>
            <td class="label">Email Akun PPDB</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->orangTua->email }}</td>
        </tr>
        <tr>
            <td class="label">Sumber Informasi Sekolah</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->sumber_informasi ?: '-' }}</td>
        </tr>
    </table>

    <div class="section-title">C. Berkas Kelengkapan Pendaftaran</div>
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
                    <td colspan="4" style="text-align: center; color: #64748b; font-style: italic; padding: 10px;">
                        Belum ada dokumen fisik/digital yang diunggah. Silakan unggah melalui dashboard orang tua.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($calonSiswa->jadwal_observasi || $calonSiswa->catatan_admin)
        <div class="section-title">D. Jadwal Observasi & Catatan Panitia</div>
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
                {{ $calonSiswa->tempat_lahir ?? 'Tempat' }}, {{ $calonSiswa->created_at->locale('id')->translatedFormat('d F Y') }}<br>
                Orang Tua / Wali Calon Siswa,
                <div class="signature-space"></div>
                <strong>( {{ $calonSiswa->orangTua->name }} )</strong>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Dokumen ini diterbitkan secara otomatis oleh Sistem PPDB Online {{ $profil['nama_sekolah'] ?? 'SDIT Binaul Ummah' }} sebagai bukti pendaftaran resmi.
    </div>
</body>
</html>

