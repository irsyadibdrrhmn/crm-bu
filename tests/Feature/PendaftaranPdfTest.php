<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PendaftaranPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_orang_tua_dapat_mendaftar_dan_diarahkan_ke_detail_dengan_opsi_cetak_formulir(): void
    {
        $orangTua = User::factory()->create(['role' => 'orang_tua']);

        $response = $this->actingAs($orangTua)->post(route('pendaftaran.store'), [
            'nama_lengkap' => 'Muhammad Bilal',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2019-05-10',
            'asal_tk' => 'TK Islam Al-Azhar',
            'sumber_informasi' => 'Website',
            'program_diminati' => 'Tahfidz',
            'alasan_memilih' => 'Ingin anak hafal Al-Qur\'an sejak dini.',
        ]);

        $calonSiswa = CalonSiswa::where('nama_lengkap', 'Muhammad Bilal')->first();
        $this->assertNotNull($calonSiswa);

        $response->assertRedirect(route('pendaftaran.detail', $calonSiswa));
        $response->assertSessionHas('just_registered', true);
        $response->assertSessionHas('success');

        // Buka halaman detail untuk memastikan tombol cetak formulir tersedia
        $detailResponse = $this->actingAs($orangTua)->get(route('pendaftaran.detail', $calonSiswa));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee(route('pendaftaran.cetak-formulir', $calonSiswa));
        $detailResponse->assertSee('Cetak Formulir Sekarang (PDF)');
    }

    public function test_orang_tua_dapat_mencetak_formulir_pendaftaran_anaknya_dalam_format_pdf(): void
    {
        $orangTua = User::factory()->create(['role' => 'orang_tua']);
        $calonSiswa = CalonSiswa::create([
            'user_id' => $orangTua->id,
            'nama_lengkap' => 'Ahmad Rayhan',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2019-03-15',
            'asal_tk' => 'TK Permata',
            'status_pendaftaran' => 'terkirim',
            'sumber_informasi' => 'Instagram',
            'program_diminati' => 'Tahfidz',
        ]);

        $response = $this->actingAs($orangTua)->get(route('pendaftaran.cetak-formulir', $calonSiswa));

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('formulir-pendaftaran-ahmad-rayhan.pdf', $response->headers->get('Content-Disposition'));
    }

    public function test_orang_tua_tidak_dapat_mengakses_formulir_anak_lain(): void
    {
        $orangTua1 = User::factory()->create(['role' => 'orang_tua']);
        $orangTua2 = User::factory()->create(['role' => 'orang_tua']);

        $calonSiswa = CalonSiswa::create([
            'user_id' => $orangTua1->id,
            'nama_lengkap' => 'Anak Orang Lain',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2019-01-01',
            'status_pendaftaran' => 'terkirim',
        ]);

        $response = $this->actingAs($orangTua2)->get(route('pendaftaran.cetak-formulir', $calonSiswa));
        $response->assertStatus(403);
    }

    public function test_surat_penerimaan_tidak_bisa_dicetak_jika_belum_diterima(): void
    {
        $orangTua = User::factory()->create(['role' => 'orang_tua']);
        $calonSiswa = CalonSiswa::create([
            'user_id' => $orangTua->id,
            'nama_lengkap' => 'Fatimah Az-Zahra',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2019-07-20',
            'status_pendaftaran' => 'terkirim',
        ]);

        $response = $this->actingAs($orangTua)->get(route('pendaftaran.cetak-pemberitahuan', $calonSiswa));
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_orang_tua_dapat_mencetak_surat_pemberitahuan_diterima_dalam_format_pdf(): void
    {
        $orangTua = User::factory()->create(['role' => 'orang_tua']);
        $calonSiswa = CalonSiswa::create([
            'user_id' => $orangTua->id,
            'nama_lengkap' => 'Fatimah Az-Zahra',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2019-07-20',
            'status_pendaftaran' => 'diterima',
            'catatan_admin' => 'Selamat ananda lulus seleksi.',
        ]);

        $response = $this->actingAs($orangTua)->get(route('pendaftaran.cetak-pemberitahuan', $calonSiswa));

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('surat-pemberitahuan-diterima-fatimah-az-zahra.pdf', $response->headers->get('Content-Disposition'));
    }

    public function test_admin_dapat_mengubah_status_menjadi_diterima_dan_mencetak_surat_pemberitahuan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $orangTua = User::factory()->create(['role' => 'orang_tua']);

        $calonSiswa = CalonSiswa::create([
            'user_id' => $orangTua->id,
            'nama_lengkap' => 'Hamzah Al-Habsyi',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2018-12-10',
            'status_pendaftaran' => 'observasi',
        ]);

        // Admin mengubah status calon siswa menjadi diterima
        $updateResponse = $this->actingAs($admin)->patch(route('pendaftaran.status', $calonSiswa), [
            'status_pendaftaran' => 'diterima',
            'catatan_admin' => 'Lolos observasi dengan nilai memuaskan. Silakan lakukan daftar ulang.',
        ]);

        $updateResponse->assertRedirect();
        $updateResponse->assertSessionHas('success');

        $calonSiswa->refresh();
        $this->assertEquals('diterima', $calonSiswa->status_pendaftaran);

        // Admin mencetak formulir PDF
        $formulirResponse = $this->actingAs($admin)->get(route('pendaftaran.cetak-formulir', $calonSiswa));
        $formulirResponse->assertStatus(200);
        $this->assertEquals('application/pdf', $formulirResponse->headers->get('Content-Type'));

        // Admin mencetak surat pemberitahuan diterima PDF
        $suratResponse = $this->actingAs($admin)->get(route('pendaftaran.cetak-pemberitahuan', $calonSiswa));
        $suratResponse->assertStatus(200);
        $this->assertEquals('application/pdf', $suratResponse->headers->get('Content-Type'));
        $this->assertStringContainsString('surat-pemberitahuan-diterima-hamzah-al-habsyi.pdf', $suratResponse->headers->get('Content-Disposition'));
    }
}

