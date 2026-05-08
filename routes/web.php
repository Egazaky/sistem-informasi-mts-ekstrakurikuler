<?php

use App\Http\Middleware\CekAdmin;
use App\Http\Middleware\CekSiswa;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\EkstraController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\RegistrationSettingsController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\HomeSettingController;

// Admin Profile Management
Route::middleware(['cekAdmin'])->group(function () {
    Route::get('admin/profil', [ProfileController::class, 'index'])->name('admin.profil.index');
    Route::post('admin/profil', [ProfileController::class, 'update'])->name('admin.profil.update');
    Route::resource('admin/berita', BeritaController::class);
    Route::resource('admin/gallery', GalleryController::class);
    Route::post('admin/gallery/about', [GalleryController::class, 'updateAbout'])->name('gallery.update-about');
    Route::resource('guru', GuruController::class);

    // Pengaturan Beranda
    Route::get('admin/home-settings', [HomeSettingController::class, 'index'])->name('admin.home-settings.index');
    Route::post('admin/home-settings', [HomeSettingController::class, 'update'])->name('admin.home-settings.update');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/data-siswa', function () {
//     return view('admin/siswa');
// });
// Route::get('/data-ekstra', function () {
//     return view('admin/ekstra');
// });
// Route::get('/data-kriteria', function () {
//     return view('admin/kriteria');
// });
// Route::get('/pertanyaan', function () {
//     return view('admin/pertanyaan');
// });
// Route::get('/proses-analisis', function () {
//     return view('admin/proses');
// });

Route::middleware([CekAdmin::class])->group(function () {

    // dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Pendaftaran Landing Page Settings
    Route::get('admin/pendaftaran/settings', [RegistrationSettingsController::class, 'index'])->name('admin.registration-settings.index');
    // Alias untuk kompatibilitas lama
    Route::get('admin/pendaftaran/settings', [RegistrationSettingsController::class, 'index'])->name('admin.pendaftaran.settings');
    Route::put('admin/pendaftaran/settings', [RegistrationSettingsController::class, 'update'])->name('admin.registration-settings.update');
    // Alias untuk form settings lama
    Route::put('admin/pendaftaran/settings', [RegistrationSettingsController::class, 'update'])->name('admin.pendaftaran.settings.update');

    // admin pendaftaran
    Route::resource('admin/pendaftaran', PendaftaranController::class)->names([
        'index' => 'admin.pendaftaran.index',
        'create' => 'admin.pendaftaran.create',
        'store' => 'admin.pendaftaran.store',
        'show' => 'admin.pendaftaran.show',
        'edit' => 'admin.pendaftaran.edit',
        'update' => 'admin.pendaftaran.update',
        'destroy' => 'admin.pendaftaran.destroy'
    ]);
    Route::post('admin/pendaftaran/{id}/update-status', [PendaftaranController::class, 'updateStatus'])->name('admin.pendaftaran.update-status');

    // data siswa
    Route::get('/data-siswa', [SiswaController::class, 'index'])->name('data-siswa');
    Route::get('/tambah-siswa', [SiswaController::class, 'tambah'])->name('tambah-siswa');
    Route::post('/proses-tambah-siswa', [SiswaController::class, 'prosesTambah'])->name('proses-tambah-siswa');
    Route::post('/proses-ubah-siswa', [SiswaController::class, 'prosesUbah'])->name('proses-ubah-siswa');
    Route::get('/ubah-siswa', [SiswaController::class, 'ubah'])->name('ubah-siswa');
    Route::get('/hapus-siswa', [SiswaController::class, 'hapus'])->name('hapus-siswa');
    Route::post('/import-siswa', [SiswaController::class, 'import'])->name('import-siswa');
    Route::post('/update-wali-kelas', [SiswaController::class, 'updateWaliKelas'])->name('update-wali-kelas');

    // data ekstra
    Route::get('/data-ekstra', [EkstraController::class, 'index'])->name('data-ekstra');
    Route::get('/tambah-ekstra', [EkstraController::class, 'tambah'])->name('tambah-ekstra');
    Route::get('/edit-ekstra', [EkstraController::class, 'edit'])->name('edit-ekstra');
    Route::post('/proses-tambah-ekstra', [EkstraController::class, 'prosesTambah'])->name('proses-tambah-ekstra');
    Route::post('/proses-edit-ekstra', [EkstraController::class, 'prosesEdit'])->name('proses-edit-ekstra');
    Route::get('/hapus-ekstra', [EkstraController::class, 'hapus'])->name('hapus-ekstra');

    // data kriteria
    Route::get('/data-kriteria', [KriteriaController::class, 'index'])->name('data-kriteria');
    Route::get('/tambah-kriteria', [KriteriaController::class, 'tambah'])->name('tambah-kriteria');
    Route::post('/proses-tambah-kriteria', [KriteriaController::class, 'prosesTambah'])->name('proses-tambah-kriteria');
    Route::get('/hapus-kriteria', [KriteriaController::class, 'hapus'])->name('hapus-kriteria');

    // proses
    Route::get('/proses', [ProsesController::class, 'index'])->name('proses');

    // pertanyaan
    Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan');
    Route::get('/tambah-pertanyaan', [PertanyaanController::class, 'tambah'])->name('tambah-pertanyaan');
    Route::post('/proses-tambah-pertanyaan', [PertanyaanController::class, 'prosesTambah'])->name('proses-tambah-pertanyaan');
    Route::post('/proses-ubah-pertanyaan', [PertanyaanController::class, 'prosesubah'])->name('proses-ubah-pertanyaan');
    Route::get('/hapus-pertanyaan', [PertanyaanController::class, 'hapus'])->name('hapus-pertanyaan');
    Route::get('/ubah-pertanyaan', [PertanyaanController::class, 'ubah'])->name('ubah-pertanyaan');

});

// // profile
// Route::get('/proses-', [SiswaController::class, 'index'])->name('data-analisis');
Route::middleware([CekSiswa::class])->group(function () {
    //siswa soal
    Route::get('/soal', [SoalController::class, 'index'])->name('soal');
    Route::post('/simpan-soal', [SoalController::class, 'simpan'])->name('simpan-soal');
    Route::get('/pilih-ekstra', [SoalController::class, 'pilihEkstra'])->name('pilih-ekstra');
    Route::post('/pilih-ekstra-proses', [SoalController::class, 'pilihEkstraProses'])->name('pilih-ekstra-proses');
    Route::get('/siswa_profil', [SiswaController::class, 'siswaProfil'])->name('siswa_profil');
    Route::get('/update_siswa_username', [SiswaController::class, 'updateUsername'])->name('update_siswa_username');
    Route::get('/update_siswa_password', [SiswaController::class, 'updatePassword'])->name('update_siswa_password');
});

// Kuesioner minat bakat
Route::middleware(['cekSiswa'])->group(function () {
    Route::get('/minat-bakat', [\App\Http\Controllers\MinatBakatController::class, 'index'])->name('minat-bakat');
    Route::post('/minat-bakat', [\App\Http\Controllers\MinatBakatController::class, 'store'])->name('minat-bakat.store');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/proses-login', [LoginController::class, 'prosesLogin'])->name('proses-login');
Route::get('/proses-logout', [LoginController::class, 'prosesLogout'])->name('proses-logout');

// Landing page & public routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/profil', [LandingController::class, 'profil'])->name('profil');
Route::get('/tentang-kami', [LandingController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/pendaftaran', [LandingController::class, 'pendaftaran'])->name('pendaftaran');
Route::post('/pendaftaran', [LandingController::class, 'storePendaftaran'])->name('pendaftaran.store');
Route::get('/berita', [LandingController::class, 'berita'])->name('landing-berita');
Route::get('/berita/{id}', [LandingController::class, 'showBerita'])->name('landing-berita-show');
