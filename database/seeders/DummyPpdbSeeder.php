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
                    'tempat_lahir' => 'Bogor',
                    'tanggal_lahir' => '2019-04-12',
                    'asal_tk' => 'TK Al Ikhlas',
                    'status_pendaftaran' => 'diverifikasi',
                    'sumber_informasi' => 'Instagram',
                    'program_diminati' => 'Tahfidz',
                    'alasan_memilih' => 'Tertarik dengan pembiasaan ibadah dan lingkungan belajar Islami.',
                    'catatan_admin' => 'Berkas sudah masuk, menunggu jadwal observasi.',
                    'jadwal_observasi' => now()->addDays(5)->setTime(9, 0),
                ],
            ],
            [
                'name' => 'Ibu Siti Rahma',
                'email' => 'siti.rahma@example.test',
                'anak' => [
                    'nama_lengkap' => 'Aisyah Humaira',
                    'tempat_lahir' => 'Depok',
                    'tanggal_lahir' => '2019-08-23',
                    'asal_tk' => 'RA Baiturrahman',
                    'status_pendaftaran' => 'observasi',
                    'sumber_informasi' => 'Teman/Keluarga',
                    'program_diminati' => 'Kurikulum Islam Terpadu',
                    'alasan_memilih' => 'Mendapat rekomendasi dari wali murid dan ingin anak belajar di sekolah Islam terpadu.',
                    'catatan_admin' => 'Observasi dijadwalkan bersama wali kelas.',
                    'jadwal_observasi' => now()->addDays(2)->setTime(10, 30),
                ],
            ],
            [
                'name' => 'Bapak Rudi Hartono',
                'email' => 'rudi.hartono@example.test',
                'anak' => [
                    'nama_lengkap' => 'Rafa Aditya',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '2018-12-05',
                    'asal_tk' => 'TK Tunas Bangsa',
                    'status_pendaftaran' => 'diterima',
                    'sumber_informasi' => 'Brosur',
                    'program_diminati' => 'Pembinaan Karakter',
                    'alasan_memilih' => 'Lokasi sekolah dekat dan program karakter sesuai kebutuhan anak.',
                    'catatan_admin' => 'Diterima. Silakan melakukan proses daftar ulang.',
                    'jadwal_observasi' => now()->subDays(3)->setTime(8, 30),
                ],
            ],
            [
                'name' => 'Ibu Maya Lestari',
                'email' => 'maya.lestari@example.test',
                'anak' => [
                    'nama_lengkap' => 'Zahra Najwa',
                    'tempat_lahir' => 'Bekasi',
                    'tanggal_lahir' => '2019-02-17',
                    'asal_tk' => 'TK Permata Hati',
                    'status_pendaftaran' => 'daftar_ulang',
                    'sumber_informasi' => 'Website',
                    'program_diminati' => 'Tahfidz',
                    'alasan_memilih' => 'Ingin melanjutkan pembiasaan hafalan yang sudah dimulai sejak TK.',
                    'catatan_admin' => 'Menunggu konfirmasi pembayaran daftar ulang.',
                    'jadwal_observasi' => now()->subDays(7)->setTime(11, 0),
                ],
            ],
            [
                'name' => 'Bapak Deni Pratama',
                'email' => 'deni.pratama@example.test',
                'anak' => [
                    'nama_lengkap' => 'Fathan Mahendra',
                    'tempat_lahir' => 'Bogor',
                    'tanggal_lahir' => '2019-10-01',
                    'asal_tk' => 'TK Al Huda',
                    'status_pendaftaran' => 'terkirim',
                    'sumber_informasi' => 'Spanduk',
                    'program_diminati' => 'Kelas Reguler',
                    'alasan_memilih' => 'Ingin mendapatkan informasi lebih lanjut tentang kurikulum dan biaya pendidikan.',
                    'catatan_admin' => 'Menunggu kelengkapan berkas dari orang tua.',
                    'jadwal_observasi' => null,
                ],
            ],
            [
                'name' => 'Ibu Lina Marlina',
                'email' => 'lina.marlina@example.test',
                'anak' => [
                    'nama_lengkap' => 'Khalisa Putri',
                    'tempat_lahir' => 'Tangerang',
                    'tanggal_lahir' => '2018-11-19',
                    'asal_tk' => 'RA Al Falah',
                    'status_pendaftaran' => 'ditolak',
                    'sumber_informasi' => 'Facebook',
                    'program_diminati' => 'Ekstrakurikuler',
                    'alasan_memilih' => 'Mencari sekolah dengan kegiatan pengembangan minat anak.',
                    'catatan_admin' => 'Belum memenuhi kriteria usia penerimaan tahun ini.',
                    'jadwal_observasi' => now()->subDays(5)->setTime(9, 30),
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

        $this->seedLeads();
        $this->seedPengumuman($admin);
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
