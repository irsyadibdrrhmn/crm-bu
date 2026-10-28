<?php

use App\Http\Controllers\AnalitikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalPpdbController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('welcome');
Route::post('/minat', [LeadController::class, 'store'])->name('leads.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:orang_tua,guru_tk')->group(function () {
        Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
        Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
        Route::post('/pendaftaran/{calonSiswa}/berkas', [PendaftaranController::class, 'uploadBerkas'])->name('pendaftaran.berkas.store');
        Route::post('/pendaftaran/{calonSiswa}/pesan', [PendaftaranController::class, 'kirimPesan'])->name('pendaftaran.pesan.store');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/analitik', [AnalitikController::class, 'index'])->name('analitik.index');
        Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('/pendaftaran/export/csv', [PendaftaranController::class, 'export'])->name('pendaftaran.export');
        Route::get('/pendaftaran/{calonSiswa}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');
        Route::patch('/pendaftaran/{calonSiswa}/status', [PendaftaranController::class, 'updateStatus'])->name('pendaftaran.status');
        Route::patch('/berkas/{berkas}', [PendaftaranController::class, 'updateBerkas'])->name('berkas.update');
        Route::post('/pendaftaran/{calonSiswa}/pesan-admin', [PendaftaranController::class, 'kirimPesan'])->name('pendaftaran.pesan.admin');
        Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
        Route::patch('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
        Route::get('/leads/export/csv', [LeadController::class, 'export'])->name('leads.export');
        Route::get('/profil-sekolah', [ProfilSekolahController::class, 'edit'])->name('profil-sekolah.edit');
        Route::patch('/profil-sekolah', [ProfilSekolahController::class, 'update'])->name('profil-sekolah.update');
        Route::resource('jadwal-ppdb', JadwalPpdbController::class)
            ->parameters(['jadwal-ppdb' => 'jadwalPpdb'])
            ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('pengumuman', PengumumanController::class)->except('show');
    });

    Route::middleware('role:orang_tua,guru_tk,admin')->group(function () {
        Route::get('/pendaftaran/{calonSiswa}/detail', [PendaftaranController::class, 'show'])->name('pendaftaran.detail');
        Route::get('/pendaftaran/{calonSiswa}/cetak-formulir', [PendaftaranController::class, 'cetakFormulir'])->name('pendaftaran.cetak-formulir');
        Route::get('/pendaftaran/{calonSiswa}/cetak-pemberitahuan', [PendaftaranController::class, 'cetakPemberitahuan'])->name('pendaftaran.cetak-pemberitahuan');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
