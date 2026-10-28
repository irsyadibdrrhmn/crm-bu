<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevisiPengujiTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengguna_bisa_mendaftar_sebagai_guru_tk(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Ustadzah Aisyah, S.Pd',
            'email' => 'aisyah.tk@example.test',
            'role' => 'guru_tk',
            'asal_sekolah' => 'TK Islam Terpadu Insan Kamil',
            'no_hp' => '081234567899',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));

        $user = User::where('email', 'aisyah.tk@example.test')->first();
        $this->assertNotNull($user);
        $this->assertEquals('guru_tk', $user->role);
        $this->assertEquals('TK Islam Terpadu Insan Kamil', $user->asal_sekolah);
        $this->assertTrue($user->isGuruTk());
    }

    public function test_guru_tk_bisa_mendaftarkan_calon_siswa_dengan_biodata_lengkap_dan_nik(): void
    {
        $guruTk = User::factory()->create([
            'role' => 'guru_tk',
            'asal_sekolah' => 'TK Permata Bunda',
            'no_hp' => '081299887766',
        ]);

        $response = $this->actingAs($guruTk)->post(route('pendaftaran.store'), [
            'nama_lengkap' => 'Zaid bin Tsabit',
            'nik' => '3201011505190088',
            'no_kk' => '3201012004120099',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2019-06-15',
            'jenis_kelamin' => 'L',
            'anak_ke' => 1,
            'jumlah_saudara' => 2,
            'asal_tk' => 'TK Permata Bunda',
            'alamat_lengkap' => 'Jl. Danau Bogor Raya Blok B No. 10',
            'rt_rw' => '02/07',
            'kelurahan_desa' => 'Katulampa',
            'kecamatan' => 'Bogor Timur',
            'kota_kabupaten' => 'Kota Bogor',
            'nama_ayah' => 'Tsabit bin Qais',
            'nik_ayah' => '3201011203840011',
            'pekerjaan_ayah' => 'Wiraswasta',
            'pendidikan_ayah' => 'S1',
            'no_hp_ayah' => '081200112233',
            'nama_ibu' => 'Ummu Tsabit',
            'nik_ibu' => '3201015609870022',
            'pekerjaan_ibu' => 'Guru',
            'pendidikan_ibu' => 'S1',
            'no_hp_ibu' => '081200112244',
            'program_diminati' => 'Tahfidz',
            'sumber_informasi' => 'Rekomendasi Guru TK',
            'alasan_memilih' => 'Ingin memperdalam hafalan Al-Qur\'an.',
        ]);

        $siswa = CalonSiswa::where('nama_lengkap', 'Zaid bin Tsabit')->first();
        $this->assertNotNull($siswa);
        $this->assertEquals('3201011505190088', $siswa->nik);
        $this->assertEquals('guru_tk', $siswa->pendaftar_peran);
        $this->assertEquals('TK Permata Bunda', $siswa->asal_tk);
        $this->assertEquals($guruTk->id, $siswa->user_id);

        $response->assertRedirect(route('pendaftaran.detail', $siswa));
    }

    public function test_dashboard_guru_tk_menampilkan_siswa_binaan(): void
    {
        $guruTk = User::factory()->create([
            'role' => 'guru_tk',
            'asal_sekolah' => 'TK Al-Hikmah',
        ]);

        CalonSiswa::create([
            'user_id' => $guruTk->id,
            'nama_lengkap' => 'Siswa Rekomendasi TK',
            'nik' => '3201011505190099',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2019-01-01',
            'asal_tk' => 'TK Al-Hikmah',
            'status_pendaftaran' => 'diterima',
            'pendaftar_peran' => 'guru_tk',
        ]);

        $response = $this->actingAs($guruTk)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Guru TK / Mitra PPDB');
        $response->assertSee('Siswa Rekomendasi TK');
        $response->assertSee('3201011505190099');
        $response->assertSee('Daftarkan Siswa Baru');
    }

    public function test_admin_dapat_mengakses_halaman_analitik_crm_ppdb(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $orangTua = User::factory()->create(['role' => 'orang_tua']);

        Lead::create([
            'nama_orang_tua' => 'Calon Wali Murid',
            'no_hp' => '081233445566',
            'status' => 'berminat',
            'sumber_informasi' => 'Instagram',
        ]);

        CalonSiswa::create([
            'user_id' => $orangTua->id,
            'nama_lengkap' => 'Siswa Analitik',
            'nik' => '3201011505190077',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2019-02-02',
            'jenis_kelamin' => 'L',
            'asal_tk' => 'TK Insan Cendekia',
            'status_pendaftaran' => 'daftar_ulang',
            'program_diminati' => 'Tahfidz',
            'sumber_informasi' => 'Instagram',
        ]);

        $response = $this->actingAs($admin)->get(route('analitik.index'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Analisis Penerimaan Siswa Baru');
        $response->assertSee('Corong Konversi CRM PPDB');
        $response->assertSee('Kontribusi Asal Sekolah');
        $response->assertSee('chartFunnel');
    }

    public function test_orang_tua_dan_guru_tk_tidak_bisa_mengakses_halaman_analitik_admin(): void
    {
        $guruTk = User::factory()->create(['role' => 'guru_tk']);
        $orangTua = User::factory()->create(['role' => 'orang_tua']);

        $response1 = $this->actingAs($guruTk)->get(route('analitik.index'));
        $response1->assertStatus(403);

        $response2 = $this->actingAs($orangTua)->get(route('analitik.index'));
        $response2->assertStatus(403);
    }

    public function test_cetak_pdf_formulir_dan_surat_memuat_nik_dan_biodata(): void
    {
        $orangTua = User::factory()->create(['role' => 'orang_tua']);

        $siswa = CalonSiswa::create([
            'user_id' => $orangTua->id,
            'nama_lengkap' => 'Hasan Al-Banna',
            'nik' => '3201011505190012',
            'no_kk' => '3201012004120034',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2019-03-03',
            'jenis_kelamin' => 'L',
            'asal_tk' => 'TK Cendekia',
            'alamat_lengkap' => 'Jl. Raya Tajur No. 20',
            'nama_ayah' => 'Ahmad Banna',
            'nik_ayah' => '3201011203840055',
            'nama_ibu' => 'Aisyah Banna',
            'nik_ibu' => '3201015609870066',
            'status_pendaftaran' => 'diterima',
            'program_diminati' => 'Tahfidz',
        ]);

        // Formulir PDF
        $resFormulir = $this->actingAs($orangTua)->get(route('pendaftaran.cetak-formulir', $siswa));
        $resFormulir->assertStatus(200);
        $this->assertEquals('application/pdf', $resFormulir->headers->get('Content-Type'));

        // Surat Diterima PDF
        $resSurat = $this->actingAs($orangTua)->get(route('pendaftaran.cetak-pemberitahuan', $siswa));
        $resSurat->assertStatus(200);
        $this->assertEquals('application/pdf', $resSurat->headers->get('Content-Type'));
    }
}

