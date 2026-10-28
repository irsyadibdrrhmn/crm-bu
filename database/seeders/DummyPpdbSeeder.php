<?php

namespace Database\Seeders;

use App\Models\CalonSiswa;
use App\Models\Lead;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DummyPpdbSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first()
            ?? User::create([
                'name' => 'Admin PPDB',
                'email' => 'admin@sdit-binaulummah.test',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]);

        $orangTuaData = [
            [
                'name' => 'Bapak Ahmad Fauzi',
                'email' => 'ahmad.fauzi@example.test',
                'anak' => [
                    'nama_lengkap' => 'Naufal Alfarizi',
                    'nik' => '3201011204190001',
                    'no_kk' => '3201011508100005',
                    'tempat_lahir' => 'Bogor',
                    'tanggal_lahir' => '2019-04-12',
                    'jenis_kelamin' => 'L',
                    'anak_ke' => 1,
                    'jumlah_saudara' => 2,
                    'asal_tk' => 'TK Al Ikhlas',
                    'alamat_lengkap' => 'Jl. Pajajaran No. 45, Baranangsiang',
                    'rt_rw' => '02/05',
                    'kelurahan_desa' => 'Tegallega',
                    'kecamatan' => 'Bogor Tengah',
                    'kota_kabupaten' => 'Kota Bogor',
                    'nama_ayah' => 'Ahmad Fauzi',
                    'nik_ayah' => '3201011005850002',
                    'pekerjaan_ayah' => 'PNS / ASN',
                    'pendidikan_ayah' => 'S1',
                    'no_hp_ayah' => '081234567810',
                    'nama_ibu' => 'Dewi Sartika',
                    'nik_ibu' => '3201015508880003',
                    'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                    'pendidikan_ibu' => 'S1',
                    'no_hp_ibu' => '081234567811',
                    'status_pendaftaran' => 'diverifikasi',
                    'sumber_informasi' => 'Instagram',
                    'program_diminati' => 'Tahfidz',
                    'alasan_memilih' => 'Tertarik dengan pembiasaan ibadah dan lingkungan belajar Islami.',
                    'catatan_admin' => 'Berkas sudah masuk, menunggu jadwal observasi.',
                    'jadwal_observasi' => now()->addDays(5)->setTime(9, 0),
                    'pendaftar_peran' => 'orang_tua',
                ],
            ],
            [
                'name' => 'Ibu Siti Rahma',
                'email' => 'siti.rahma@example.test',
                'anak' => [
                    'nama_lengkap' => 'Aisyah Humaira',
                    'nik' => '3201026308190002',
                    'no_kk' => '3201021201120008',
                    'tempat_lahir' => 'Depok',
                    'tanggal_lahir' => '2019-08-23',
                    'jenis_kelamin' => 'P',
                    'anak_ke' => 2,
                    'jumlah_saudara' => 3,
                    'asal_tk' => 'RA Baiturrahman',
                    'alamat_lengkap' => 'Jl. Margonda Raya Gg. Haji Mahali No. 18',
                    'rt_rw' => '04/02',
                    'kelurahan_desa' => 'Pondok Cina',
                    'kecamatan' => 'Beji',
                    'kota_kabupaten' => 'Kota Depok',
                    'nama_ayah' => 'Bambang Irawan',
                    'nik_ayah' => '3201021503830001',
                    'pekerjaan_ayah' => 'Karyawan Swasta',
                    'pendidikan_ayah' => 'S1',
                    'no_hp_ayah' => '081234567820',
                    'nama_ibu' => 'Siti Rahma',
                    'nik_ibu' => '3201025506860004',
                    'pekerjaan_ibu' => 'Guru',
                    'pendidikan_ibu' => 'S1',
                    'no_hp_ibu' => '081234567821',
                    'status_pendaftaran' => 'observasi',
                    'sumber_informasi' => 'Teman/Keluarga',
                    'program_diminati' => 'Kurikulum Islam Terpadu',
                    'alasan_memilih' => 'Mendapat rekomendasi dari wali murid dan ingin anak belajar di sekolah Islam terpadu.',
                    'catatan_admin' => 'Observasi dijadwalkan bersama wali kelas.',
                    'jadwal_observasi' => now()->addDays(2)->setTime(10, 30),
                    'pendaftar_peran' => 'orang_tua',
                ],
            ],
            [
                'name' => 'Bapak Rudi Hartono',
                'email' => 'rudi.hartono@example.test',
                'anak' => [
                    'nama_lengkap' => 'Rafa Aditya',
                    'nik' => '3171030512180003',
                    'no_kk' => '3171032009110002',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '2018-12-05',
                    'jenis_kelamin' => 'L',
                    'anak_ke' => 1,
                    'jumlah_saudara' => 1,
                    'asal_tk' => 'TK Tunas Bangsa',
                    'alamat_lengkap' => 'Perumahan Griya Indah Blok B3 No. 7',
                    'rt_rw' => '01/08',
                    'kelurahan_desa' => 'Cibinong',
                    'kecamatan' => 'Cibinong',
                    'kota_kabupaten' => 'Kab. Bogor',
                    'nama_ayah' => 'Rudi Hartono',
                    'nik_ayah' => '3171031207800003',
                    'pekerjaan_ayah' => 'Wiraswasta',
                    'pendidikan_ayah' => 'SMA/SMK',
                    'no_hp_ayah' => '081234567830',
                    'nama_ibu' => 'Endang Sulastri',
                    'nik_ibu' => '3171034409840005',
                    'pekerjaan_ibu' => 'Pedagang',
                    'pendidikan_ibu' => 'SMA/SMK',
                    'no_hp_ibu' => '081234567831',
                    'status_pendaftaran' => 'diterima',
                    'sumber_informasi' => 'Brosur',
                    'program_diminati' => 'Pembinaan Karakter',
                    'alasan_memilih' => 'Lokasi sekolah dekat dan program karakter sesuai kebutuhan anak.',
                    'catatan_admin' => 'Diterima. Silakan melakukan proses daftar ulang.',
                    'jadwal_observasi' => now()->subDays(3)->setTime(8, 30),
                    'pendaftar_peran' => 'orang_tua',
                ],
            ],
            [
                'name' => 'Ibu Maya Lestari',
                'email' => 'maya.lestari@example.test',
                'anak' => [
                    'nama_lengkap' => 'Zahra Najwa',
                    'nik' => '3216015702190004',
                    'no_kk' => '3216011103130006',
                    'tempat_lahir' => 'Bekasi',
                    'tanggal_lahir' => '2019-02-17',
                    'jenis_kelamin' => 'P',
                    'anak_ke' => 2,
                    'jumlah_saudara' => 2,
                    'asal_tk' => 'TK Permata Hati',
                    'alamat_lengkap' => 'Jl. Raya Tajur Gg. Gudang No. 12',
                    'rt_rw' => '03/04',
                    'kelurahan_desa' => 'Tajur',
                    'kecamatan' => 'Bogor Timur',
                    'kota_kabupaten' => 'Kota Bogor',
                    'nama_ayah' => 'Hendro Prasetyo',
                    'nik_ayah' => '3216011504820002',
                    'pekerjaan_ayah' => 'Arsitek',
                    'pendidikan_ayah' => 'S1',
                    'no_hp_ayah' => '081234567840',
                    'nama_ibu' => 'Maya Lestari',
                    'nik_ibu' => '3216016108850007',
                    'pekerjaan_ibu' => 'Desainer Grafis',
                    'pendidikan_ibu' => 'S1',
                    'no_hp_ibu' => '081234567841',
                    'status_pendaftaran' => 'daftar_ulang',
                    'sumber_informasi' => 'Website',
                    'program_diminati' => 'Tahfidz',
                    'alasan_memilih' => 'Ingin melanjutkan pembiasaan hafalan yang sudah dimulai sejak TK.',
                    'catatan_admin' => 'Menunggu konfirmasi pembayaran daftar ulang.',
                    'jadwal_observasi' => now()->subDays(7)->setTime(11, 0),
                    'pendaftar_peran' => 'orang_tua',
                ],
            ],
            [
                'name' => 'Bapak Deni Pratama',
                'email' => 'deni.pratama@example.test',
                'anak' => [
                    'nama_lengkap' => 'Fathan Mahendra',
                    'nik' => '3201030110190005',
                    'no_kk' => '3201031405140009',
                    'tempat_lahir' => 'Bogor',
                    'tanggal_lahir' => '2019-10-01',
                    'jenis_kelamin' => 'L',
                    'anak_ke' => 1,
                    'jumlah_saudara' => 1,
                    'asal_tk' => 'TK Al Huda',
                    'alamat_lengkap' => 'Kp. Babakan Tengah RT 02 RW 03',
                    'rt_rw' => '02/03',
                    'kelurahan_desa' => 'Babakan',
                    'kecamatan' => 'Dramaga',
                    'kota_kabupaten' => 'Kab. Bogor',
                    'nama_ayah' => 'Deni Pratama',
                    'nik_ayah' => '3201031109860004',
                    'pekerjaan_ayah' => 'Dosen / Peneliti',
                    'pendidikan_ayah' => 'S2',
                    'no_hp_ayah' => '081234567850',
                    'nama_ibu' => 'Fitria Anggraini',
                    'nik_ibu' => '3201035212890006',
                    'pekerjaan_ibu' => 'Apoteker',
                    'pendidikan_ibu' => 'S1',
                    'no_hp_ibu' => '081234567851',
                    'status_pendaftaran' => 'terkirim',
                    'sumber_informasi' => 'Spanduk',
                    'program_diminati' => 'Kelas Reguler',
                    'alasan_memilih' => 'Ingin mendapatkan informasi lebih lanjut tentang kurikulum dan biaya pendidikan.',
                    'catatan_admin' => 'Menunggu kelengkapan berkas dari orang tua.',
                    'jadwal_observasi' => null,
                    'pendaftar_peran' => 'orang_tua',
                ],
            ],
        ];

        foreach ($orangTuaData as $item) {
            $orangTua = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'role' => 'orang_tua',
                    'password' => Hash::make('password'),
                ]
            );

            $calonSiswa = CalonSiswa::updateOrCreate(
                ['nama_lengkap' => $item['anak']['nama_lengkap']],
                array_merge($item['anak'], ['user_id' => $orangTua->id])
            );

            $this->seedBerkas($calonSiswa);
            $this->seedPesan($calonSiswa, $orangTua, $admin);
        }

        // Akun Guru TK Mitra & Siswa Kolektif yang didaftarkan
        $this->seedGuruTk($admin);

        $this->seedLeads();
        $this->seedPengumuman($admin);
    }

    private function seedGuruTk(User $admin): void
    {
        $guruTk = User::updateOrCreate(
            ['email' => 'guru.tk@sdit-binaulummah.test'],
            [
                'name' => 'Ustadzah Nurul Hidayah, S.Pd',
                'role' => 'guru_tk',
                'asal_sekolah' => 'TK Islam Al-Ikhlas Bogor',
                'no_hp' => '081298765432',
                'password' => Hash::make('password'),
            ]
        );

        $siswaKolektif = [
            [
                'nama_lengkap' => 'Muhammad Bilal Ramadhan',
                'nik' => '3201011505190006',
                'no_kk' => '3201012004120011',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2019-05-15',
                'jenis_kelamin' => 'L',
                'anak_ke' => 1,
                'jumlah_saudara' => 2,
                'asal_tk' => 'TK Islam Al-Ikhlas Bogor',
                'alamat_lengkap' => 'Jl. Achmad Adnawijaya No. 88, Tegal Gundil',
                'rt_rw' => '03/06',
                'kelurahan_desa' => 'Tegal Gundil',
                'kecamatan' => 'Bogor Utara',
                'kota_kabupaten' => 'Kota Bogor',
                'nama_ayah' => 'Rahmat Ramadhan',
                'nik_ayah' => '3201011203840005',
                'pekerjaan_ayah' => 'Konsultan IT',
                'pendidikan_ayah' => 'S1',
                'no_hp_ayah' => '081311223344',
                'nama_ibu' => 'Halimah Tussadiah',
                'nik_ibu' => '3201015609870009',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'pendidikan_ibu' => 'D3',
                'no_hp_ibu' => '081311223345',
                'status_pendaftaran' => 'diterima',
                'sumber_informasi' => 'Rekomendasi Guru TK',
                'program_diminati' => 'Tahfidz',
                'alasan_memilih' => 'Rekomendasi dari pihak TK Al-Ikhlas karena siswa berprestasi dalam hafalan juz 30.',
                'catatan_admin' => 'Selamat, ananda dinyatakan diterima jalur prestasi tahfidz TK mitra.',
                'jadwal_observasi' => now()->subDays(2)->setTime(9, 0),
                'pendaftar_peran' => 'guru_tk',
            ],
            [
                'nama_lengkap' => 'Khadijah Al-Kubro',
                'nik' => '3201015907190007',
                'no_kk' => '3201011002130015',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2019-07-19',
                'jenis_kelamin' => 'P',
                'anak_ke' => 2,
                'jumlah_saudara' => 3,
                'asal_tk' => 'TK Islam Al-Ikhlas Bogor',
                'alamat_lengkap' => 'Komplek Bantar Jati Indah Blok C No. 4',
                'rt_rw' => '01/09',
                'kelurahan_desa' => 'Bantarjati',
                'kecamatan' => 'Bogor Utara',
                'kota_kabupaten' => 'Kota Bogor',
                'nama_ayah' => 'Hasan Basri',
                'nik_ayah' => '3201010808810004',
                'pekerjaan_ayah' => 'Wirausaha',
                'pendidikan_ayah' => 'S1',
                'no_hp_ayah' => '081355667788',
                'nama_ibu' => 'Fatimah Az-Zahra',
                'nik_ibu' => '3201016211830008',
                'pekerjaan_ibu' => 'Dokter Gigi',
                'pendidikan_ibu' => 'S1',
                'no_hp_ibu' => '081355667789',
                'status_pendaftaran' => 'observasi',
                'sumber_informasi' => 'Rekomendasi Guru TK',
                'program_diminati' => 'Kurikulum Islam Terpadu',
                'alasan_memilih' => 'Kolektif pendaftaran dari TK Al-Ikhlas.',
                'catatan_admin' => 'Jadwal observasi pemetaan bakat anak.',
                'jadwal_observasi' => now()->addDays(3)->setTime(10, 0),
                'pendaftar_peran' => 'guru_tk',
            ]
        ];

        foreach ($siswaKolektif as $data) {
            $siswa = CalonSiswa::updateOrCreate(
                ['nama_lengkap' => $data['nama_lengkap']],
                array_merge($data, ['user_id' => $guruTk->id])
            );

            $this->seedBerkas($siswa);
        }
    }

    private function seedBerkas(CalonSiswa $calonSiswa): void
    {
        Storage::disk('public')->put('berkas-ppdb/dummy-berkas.txt', 'File dummy untuk simulasi berkas PPDB.');

        $berkas = [
            ['jenis_berkas' => 'Akta Kelahiran', 'status' => 'lengkap', 'catatan' => 'Dokumen terbaca jelas.'],
            ['jenis_berkas' => 'Kartu Keluarga', 'status' => $calonSiswa->status_pendaftaran === 'terkirim' ? 'menunggu' : 'lengkap', 'catatan' => $calonSiswa->status_pendaftaran === 'terkirim' ? 'Mohon segera unggah dokumen.' : 'Sesuai data orang tua.'],
            ['jenis_berkas' => 'Pas Foto', 'status' => in_array($calonSiswa->status_pendaftaran, ['diverifikasi', 'observasi']) ? 'revisi' : 'lengkap', 'catatan' => in_array($calonSiswa->status_pendaftaran, ['diverifikasi', 'observasi']) ? 'Mohon unggah foto dengan latar polos.' : 'Foto diterima.'],
        ];

        foreach ($berkas as $item) {
            $calonSiswa->berkas()->updateOrCreate(
                ['jenis_berkas' => $item['jenis_berkas']],
                [
                    'file_path' => 'berkas-ppdb/dummy-berkas.txt',
                    'status' => $item['status'],
                    'catatan' => $item['catatan'],
                ]
            );
        }
    }

    private function seedPesan(CalonSiswa $calonSiswa, User $orangTua, User $admin): void
    {
        $messages = [
            [$orangTua->id, 'Assalamualaikum, apakah berkas pendaftaran anak saya sudah diterima?'],
            [$admin->id, 'Waalaikumsalam, berkas sudah masuk. Silakan pantau status validasi melalui dashboard.'],
        ];

        foreach ($messages as [$userId, $pesan]) {
            $calonSiswa->pesan()->firstOrCreate([
                'user_id' => $userId,
                'pesan' => $pesan,
            ]);
        }
    }

    private function seedLeads(): void
    {
        $leads = [
            ['nama_orang_tua' => 'Ibu Rina Anggraini', 'no_hp' => '081234567801', 'nama_anak' => 'Bilqis', 'sumber_informasi' => 'Instagram', 'status' => 'baru', 'catatan' => 'Menanyakan biaya masuk dan jadwal observasi.'],
            ['nama_orang_tua' => 'Bapak Hendra Saputra', 'no_hp' => '081234567802', 'nama_anak' => 'Arkan', 'sumber_informasi' => 'Brosur', 'status' => 'dihubungi', 'catatan' => 'Sudah dihubungi via WhatsApp, tertarik survei sekolah.'],
            ['nama_orang_tua' => 'Ibu Fitri Nuraini', 'no_hp' => '081234567803', 'nama_anak' => 'Nabila', 'sumber_informasi' => 'Teman/Keluarga', 'status' => 'berminat', 'catatan' => 'Minta dikirimkan informasi program tahfidz.'],
            ['nama_orang_tua' => 'Bapak Yoga Permana', 'no_hp' => '081234567804', 'nama_anak' => 'Rayyan', 'sumber_informasi' => 'Website', 'status' => 'daftar', 'catatan' => 'Sudah diarahkan membuat akun orang tua.'],
            ['nama_orang_tua' => 'Ibu Nia Kartika', 'no_hp' => '081234567805', 'nama_anak' => 'Hana', 'sumber_informasi' => 'Facebook', 'status' => 'tidak_berminat', 'catatan' => 'Memilih sekolah yang lebih dekat rumah.'],
            ['nama_orang_tua' => 'Ibu Dewi Astuti', 'no_hp' => '081234567806', 'nama_anak' => 'Faris', 'sumber_informasi' => 'Rekomendasi Guru TK', 'status' => 'berminat', 'catatan' => 'Mendapat info dari guru TK Al Ikhlas.'],
            ['nama_orang_tua' => 'Bapak Arif Gunawan', 'no_hp' => '081234567807', 'nama_anak' => 'Salma', 'sumber_informasi' => 'Spanduk', 'status' => 'dihubungi', 'catatan' => 'Tanya jadwal gelombang 2.'],
        ];

        foreach ($leads as $lead) {
            Lead::updateOrCreate(
                ['no_hp' => $lead['no_hp']],
                $lead
            );
        }
    }

    private function seedPengumuman(User $admin): void
    {
        $pengumumans = [
            [
                'judul' => 'Jadwal Observasi Calon Siswa Gelombang Pertama',
                'konten' => 'Observasi calon siswa gelombang pertama dilaksanakan sesuai jadwal yang tertera pada dashboard masing-masing orang tua.',
                'tanggal_publish' => now()->addDays(1)->toDateString(),
            ],
            [
                'judul' => 'Daftar Ulang Siswa Diterima',
                'konten' => 'Orang tua calon siswa yang telah dinyatakan diterima dapat melakukan proses daftar ulang melalui panitia PPDB.',
                'tanggal_publish' => now()->addDays(2)->toDateString(),
            ],
        ];

        foreach ($pengumumans as $pengumuman) {
            Pengumuman::updateOrCreate(
                ['judul' => $pengumuman['judul']],
                array_merge($pengumuman, ['admin_id' => $admin->id])
            );
        }
    }
}
