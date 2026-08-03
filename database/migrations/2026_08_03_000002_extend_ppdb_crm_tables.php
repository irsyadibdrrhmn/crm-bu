<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE calon_siswas MODIFY status_pendaftaran ENUM('pending','terkirim','diverifikasi','observasi','diterima','ditolak','daftar_ulang') DEFAULT 'terkirim'");
        }

        Schema::table('calon_siswas', function (Blueprint $table) {
            if (! Schema::hasColumn('calon_siswas', 'sumber_informasi')) {
                $table->string('sumber_informasi')->nullable()->after('status_pendaftaran');
                $table->string('program_diminati')->nullable()->after('sumber_informasi');
                $table->text('alasan_memilih')->nullable()->after('program_diminati');
                $table->text('catatan_admin')->nullable()->after('alasan_memilih');
                $table->dateTime('jadwal_observasi')->nullable()->after('catatan_admin');
            }
        });

        if (! Schema::hasTable('profil_sekolahs')) {
            Schema::create('profil_sekolahs', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('jadwal_ppdbs')) {
            Schema::create('jadwal_ppdbs', function (Blueprint $table) {
                $table->id();
                $table->string('tahapan');
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai')->nullable();
                $table->text('keterangan')->nullable();
                $table->unsignedInteger('urutan')->default(0);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('leads')) {
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
        }

        if (! Schema::hasTable('berkas_pendaftarans')) {
            Schema::create('berkas_pendaftarans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('calon_siswa_id')->constrained('calon_siswas')->cascadeOnDelete();
                $table->string('jenis_berkas');
                $table->string('file_path');
                $table->string('status')->default('menunggu');
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('pesan_pendaftarans')) {
            Schema::create('pesan_pendaftarans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('calon_siswa_id')->constrained('calon_siswas')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->text('pesan');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan_pendaftarans');
        Schema::dropIfExists('berkas_pendaftarans');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('jadwal_ppdbs');
        Schema::dropIfExists('profil_sekolahs');

        Schema::table('calon_siswas', function (Blueprint $table) {
            $table->dropColumn([
                'sumber_informasi',
                'program_diminati',
                'alasan_memilih',
                'catatan_admin',
                'jadwal_observasi',
            ]);
        });
    }
};
