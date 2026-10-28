<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calon_siswas', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('nama_lengkap');
            $table->string('no_kk', 16)->nullable()->after('nik');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('tanggal_lahir');
            $table->unsignedSmallInteger('anak_ke')->nullable()->after('jenis_kelamin');
            $table->unsignedSmallInteger('jumlah_saudara')->nullable()->after('anak_ke');

            // Alamat
            $table->text('alamat_lengkap')->nullable()->after('asal_tk');
            $table->string('rt_rw', 20)->nullable()->after('alamat_lengkap');
            $table->string('kelurahan_desa')->nullable()->after('rt_rw');
            $table->string('kecamatan')->nullable()->after('kelurahan_desa');
            $table->string('kota_kabupaten')->nullable()->after('kecamatan');

            // Data Ayah
            $table->string('nama_ayah')->nullable()->after('kota_kabupaten');
            $table->string('nik_ayah', 16)->nullable()->after('nama_ayah');
            $table->string('pekerjaan_ayah')->nullable()->after('nik_ayah');
            $table->string('pendidikan_ayah')->nullable()->after('pekerjaan_ayah');
            $table->string('no_hp_ayah', 30)->nullable()->after('pendidikan_ayah');

            // Data Ibu
            $table->string('nama_ibu')->nullable()->after('no_hp_ayah');
            $table->string('nik_ibu', 16)->nullable()->after('nama_ibu');
            $table->string('pekerjaan_ibu')->nullable()->after('nik_ibu');
            $table->string('pendidikan_ibu')->nullable()->after('pekerjaan_ibu');
            $table->string('no_hp_ibu', 30)->nullable()->after('pendidikan_ibu');

            // Data Wali (opsional)
            $table->string('nama_wali')->nullable()->after('no_hp_ibu');
            $table->string('pekerjaan_wali')->nullable()->after('nama_wali');
            $table->string('no_hp_wali', 30)->nullable()->after('pekerjaan_wali');

            // Peran pendaftar: orang_tua atau guru_tk
            $table->string('pendaftar_peran', 30)->default('orang_tua')->after('no_hp_wali');
        });
    }

    public function down(): void
    {
        Schema::table('calon_siswas', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'no_kk',
                'jenis_kelamin',
                'anak_ke',
                'jumlah_saudara',
                'alamat_lengkap',
                'rt_rw',
                'kelurahan_desa',
                'kecamatan',
                'kota_kabupaten',
                'nama_ayah',
                'nik_ayah',
                'pekerjaan_ayah',
                'pendidikan_ayah',
                'no_hp_ayah',
                'nama_ibu',
                'nik_ibu',
                'pekerjaan_ibu',
                'pendidikan_ibu',
                'no_hp_ibu',
                'nama_wali',
                'pekerjaan_wali',
                'no_hp_wali',
                'pendaftar_peran',
            ]);
        });
    }
};

