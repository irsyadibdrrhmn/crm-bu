<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calon_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('asal_tk')->nullable();
            $table->string('status_pendaftaran')->default('terkirim');
            $table->string('sumber_informasi')->nullable();
            $table->string('program_diminati')->nullable();
            $table->text('alasan_memilih')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->dateTime('jadwal_observasi')->nullable();
            $table->timestamps();
        });

        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul');
            $table->text('konten');
            $table->date('tanggal_publish');
            $table->timestamps();
        });

        Schema::create('profil_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('jadwal_ppdbs', function (Blueprint $table) {
            $table->id();
            $table->string('tahapan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('nama_orang_tua');
            $table->string('no_hp');
            $table->string('nama_anak')->nullable();
            $table->string('sumber_informasi')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->default('baru');
            $table->timestamps();
        });

        Schema::create('berkas_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_siswa_id')->constrained('calon_siswas')->cascadeOnDelete();
            $table->string('jenis_berkas');
            $table->string('file_path');
            $table->string('status')->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('pesan_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_siswa_id')->constrained('calon_siswas')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('pesan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan_pendaftarans');
        Schema::dropIfExists('berkas_pendaftarans');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('jadwal_ppdbs');
        Schema::dropIfExists('profil_sekolahs');
        Schema::dropIfExists('pengumumans');
        Schema::dropIfExists('calon_siswas');
    }
};
