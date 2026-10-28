<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pemberitahuan Diterima - {{ $calonSiswa->nama_lengkap }}</title>
    <style>
        @page {
            margin: 15mm 20mm 15mm 20mm;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #0f172a;
            font-size: 10pt;
            line-height: 1.45;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-box {
            width: 62px;
            height: 62px;
            background-color: #047857;
            color: #ffffff;
            font-weight: bold;
            font-size: 18pt;
            text-align: center;
            line-height: 62px;
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
        .letter-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 9.5pt;
        }
        .letter-info td {
            vertical-align: top;
            padding: 2px 0;
        }
        .greeting {
            margin-top: 10px;
            margin-bottom: 8px;
            font-style: italic;
            font-weight: bold;
        }
        .paragraph {
            text-align: justify;
            margin-bottom: 10px;
            text-indent: 28px;
            font-size: 9.5pt;
        }
        .data-table {
            width: 92%;
            margin: 6px auto 12px auto;
            border-collapse: collapse;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
        }
        .data-table td {
            padding: 5px 8px;
            font-size: 9pt;
            vertical-align: top;
        }
        .data-table td.label {
            width: 32%;
            color: #475569;
        }
        .data-table td.separator {
            width: 4%;
            text-align: center;
            color: #64748b;
        }
        .data-table td.value {
            width: 64%;
            font-weight: bold;
            color: #0f172a;
        }
        .decision-box {
            border: 2px solid #059669;
            background-color: #ecfdf5;
            padding: 10px 14px;
            text-align: center;
            margin: 12px 0;
            border-radius: 6px;
        }
        .decision-title {
            font-size: 13pt;
            font-weight: bold;
            color: #065f46;
            letter-spacing: 1px;
            margin: 0;
        }
        .decision-sub {
            font-size: 9.5pt;
            color: #047857;
            font-weight: 600;
            margin: 3px 0 0 0;
        }
        .notes-box {
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 8px 12px;
            margin: 10px 0;
            font-size: 9pt;
            color: #92400e;
        }
        .notes-box strong {
            display: block;
            margin-bottom: 3px;
        }
        .closing {
            margin-top: 10px;
            margin-bottom: 16px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
            margin-top: 16px;
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

    <table class="letter-info">
        <tr>
            <td style="width: 12%;">Nomor</td>
            <td style="width: 2%;">:</td>
            <td style="width: 48%;">421.1/{{ str_pad($calonSiswa->id, 3, '0', STR_PAD_LEFT) }}/PPDB-SDIT-BU/{{ date('Y') }}</td>
            <td style="width: 38%; text-align: right;">{{ $calonSiswa->tempat_lahir ?? 'Bogor' }}, {{ now()->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>-</td>
            <td rowspan="2" style="text-align: right; vertical-align: top;">
                Kepada Yth.<br>
                <strong>Bpk/Ibu Orang Tua / Wali</strong><br>
                dari <strong>{{ $calonSiswa->nama_lengkap }}</strong><br>
                di Tempat
            </td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td><strong>Surat Pemberitahuan Penerimaan Siswa Baru</strong></td>
        </tr>
    </table>

    <div class="greeting">Assalamu’alaikum Warahmatullahi Wabarakatuh,</div>

    <div class="paragraph">
        Segala puji dan rasa syukur senantiasa kita panjatkan ke hadirat Allah Subhanahu Wa Ta'ala atas limpahan rahmat, taufik, dan hidayah-Nya. Shalawat serta salam semoga senantiasa tercurahkan kepada suri teladan kita, Nabi Muhammad Shallallahu 'Alaihi Wasallam, beserta keluarga, sahabat, dan pengikutnya.
    </div>

    <div class="paragraph">
        Berdasarkan hasil seleksi berkas administrasi dan observasi Penerimaan Peserta Didik Baru (PPDB) {{ $profil['nama_sekolah'] ?? 'SDIT Binaul Ummah' }} Tahun Pelajaran {{ date('Y') }}/{{ date('Y') + 1 }}, dengan rasa syukur dan bangga, panitia PPDB memberitahukan bahwa calon peserta didik di bawah ini:
    </div>

    <table class="data-table">
        <tr>
            <td class="label">Nomor Registrasi</td>
            <td class="separator">:</td>
            <td class="value">REG-{{ str_pad($calonSiswa->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap Anak</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label">NIK Calon Siswa</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->nik ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tempat, Tanggal Lahir</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->tempat_lahir }}, {{ $calonSiswa->tanggal_lahir->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Asal TK / Sekolah</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->asal_tk ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Program Pilihan</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->program_diminati ?: 'Reguler' }}</td>
        </tr>
        <tr>
            <td class="label">Orang Tua / Wali</td>
            <td class="separator">:</td>
            <td class="value">{{ $calonSiswa->orangTua->name }}</td>
        </tr>
    </table>

    <div class="decision-box">
        <h3 class="decision-title">DINYATAKAN DITERIMA</h3>
        <p class="decision-sub">Sebagai Peserta Didik Baru {{ $profil['nama_sekolah'] ?? 'SDIT Binaul Ummah' }} Tahun Pelajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <div class="paragraph">
        Kami mengucapkan selamat atas diterimanya ananda menjadi bagian dari keluarga besar {{ $profil['nama_sekolah'] ?? 'SDIT Binaul Ummah' }}. Selanjutnya, Bapak/Ibu orang tua/wali dimohon untuk melakukan proses <strong>Daftar Ulang</strong> sesuai dengan ketentuan yang berlaku.
    </div>

    @if ($calonSiswa->catatan_admin)
        <div class="notes-box">
            <strong>Catatan Khusus dari Panitia:</strong>
            {{ $calonSiswa->catatan_admin }}
        </div>
    @endif

    <div class="paragraph">
        Demikian surat pemberitahuan ini kami sampaikan. Atas kepercayaan dan kerja sama Bapak/Ibu, kami sampaikan terima kasih yang sebesar-besarnya. Semoga Allah SWT memberkahi ikhtiar kita dalam mendidik generasi yang sholeh, cerdas, dan berkarakter mulia.
    </div>

    <div class="greeting closing">Wassalamu’alaikum Warahmatullahi Wabarakatuh.</div>

    <table class="signature-table">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;">
                {{ $calonSiswa->tempat_lahir ?? 'Bogor' }}, {{ now()->locale('id')->translatedFormat('d F Y') }}<br>
                Panitia PPDB,<br>
                <strong>{{ $profil['nama_sekolah'] ?? 'SDIT Binaul Ummah' }}</strong>
                <div class="signature-space"></div>
                <strong><u>Panitia PPDB & Pimpinan Sekolah</u></strong><br>
                <span style="font-size: 8pt; color: #64748b;">NIP/NPY: PPDB-{{ date('Y') }}-01</span>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Surat ini merupakan bukti resmi hasil seleksi PPDB Online {{ $profil['nama_sekolah'] ?? 'SDIT Binaul Ummah' }} dan dicetak secara elektronik tanpa memerlukan cap basah konvensional.
    </div>
</body>
</html>

