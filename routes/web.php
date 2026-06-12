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

// =========== PRESTI ROUTES ===========
Route::prefix('presti')->name('presti.')->group(function () {
    // Auth (public)
    Route::get('/login', [\App\Http\Controllers\Presti\PrestiAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Presti\PrestiAuthController::class, 'prosesLogin']);
    Route::get('/logout', [\App\Http\Controllers\Presti\PrestiAuthController::class, 'logout'])->name('logout');

    // Protected routes
    Route::middleware('cekPresti')->group(function () {
        Route::get('/', [\App\Http\Controllers\Presti\PrestiDashboardController::class, 'index'])->name('dashboard');

        // Admin only
        Route::middleware('cekPrestiRole:admin')->group(function () {
            // Siswa CRUD
            Route::get('/siswa', [\App\Http\Controllers\Presti\PrestiSiswaController::class, 'index'])->name('siswa.index');
            Route::post('/siswa', [\App\Http\Controllers\Presti\PrestiSiswaController::class, 'store'])->name('siswa.store');
            Route::put('/siswa/{id}', [\App\Http\Controllers\Presti\PrestiSiswaController::class, 'update'])->name('siswa.update');
            Route::delete('/siswa/{id}', [\App\Http\Controllers\Presti\PrestiSiswaController::class, 'destroy'])->name('siswa.destroy');
            Route::get('/siswa/template', [\App\Http\Controllers\Presti\PrestiSiswaController::class, 'downloadTemplate'])->name('siswa.template');
            Route::post('/siswa/import', [\App\Http\Controllers\Presti\PrestiSiswaController::class, 'importCSV'])->name('siswa.import');

            // Cetak QR batch
            Route::get('/absensi/cetak-qr', [\App\Http\Controllers\Presti\PrestiAbsensiController::class, 'cetakQR'])->name('absensi.cetak-qr');

            // Tagihan Manage
            Route::get('/tagihan', [\App\Http\Controllers\Presti\PrestiTagihanController::class, 'manage'])->name('tagihan.manage');
            Route::post('/tagihan', [\App\Http\Controllers\Presti\PrestiTagihanController::class, 'store'])->name('tagihan.store');
            Route::put('/tagihan/{id}', [\App\Http\Controllers\Presti\PrestiTagihanController::class, 'update'])->name('tagihan.update');
            Route::delete('/tagihan/{id}', [\App\Http\Controllers\Presti\PrestiTagihanController::class, 'destroy'])->name('tagihan.destroy');
            Route::post('/tagihan/{id}/cash', [\App\Http\Controllers\Presti\PrestiTagihanController::class, 'bayarCash'])->name('tagihan.cash');
            Route::post('/tagihan/{id}/setuju', [\App\Http\Controllers\Presti\PrestiTagihanController::class, 'verifikasiSetuju'])->name('tagihan.setuju');
            Route::post('/tagihan/{id}/tolak', [\App\Http\Controllers\Presti\PrestiTagihanController::class, 'verifikasiTolak'])->name('tagihan.tolak');
        });

        // Admin & Guru
        Route::middleware('cekPrestiRole:admin,guru')->group(function () {
            // Dashboards
            Route::get('/dashboard/admin', [\App\Http\Controllers\Presti\PrestiDashboardController::class, 'admin'])->name('dashboard.admin');
            Route::get('/dashboard/guru', [\App\Http\Controllers\Presti\PrestiDashboardController::class, 'guru'])->name('dashboard.guru');

            // Scan Absensi
            Route::get('/absensi/scan', [\App\Http\Controllers\Presti\PrestiAbsensiController::class, 'scan'])->name('absensi.scan');
            Route::post('/absensi/scan', [\App\Http\Controllers\Presti\PrestiAbsensiController::class, 'scanProcess']);
            Route::get('/absensi/riwayat', [\App\Http\Controllers\Presti\PrestiAbsensiController::class, 'getRiwayat'])->name('absensi.riwayat');

            // Analisis
            Route::get('/analisis/kelas', [\App\Http\Controllers\Presti\PrestiAnalisisController::class, 'kelas'])->name('analisis.kelas');

            // Export Excel
            Route::get('/absensi/export', [\App\Http\Controllers\Presti\PrestiAbsensiController::class, 'exportExcel'])->name('absensi.export');
        });

        // Siswa only
        Route::middleware('cekPrestiRole:siswa')->group(function () {
            Route::get('/dashboard/siswa', [\App\Http\Controllers\Presti\PrestiDashboardController::class, 'siswa'])->name('dashboard.siswa');
            Route::get('/qr-siswa', [\App\Http\Controllers\Presti\PrestiQRController::class, 'index'])->name('qr-siswa');
            Route::get('/tagihan/siswa', [\App\Http\Controllers\Presti\PrestiTagihanController::class, 'tagihanSiswa'])->name('tagihan.siswa');
            Route::get('/password', [\App\Http\Controllers\Presti\PrestiPasswordController::class, 'index'])->name('password');
            Route::post('/password', [\App\Http\Controllers\Presti\PrestiPasswordController::class, 'update'])->name('password.update');
        });

        // Ortu only
        Route::middleware('cekPrestiRole:ortu')->group(function () {
            Route::get('/dashboard/ortu', [\App\Http\Controllers\Presti\PrestiDashboardController::class, 'ortu'])->name('dashboard.ortu');
            Route::get('/tagihan/ortu', [\App\Http\Controllers\Presti\PrestiTagihanController::class, 'tagihanOrtu'])->name('tagihan.ortu');
            Route::post('/tagihan/{id}/upload', [\App\Http\Controllers\Presti\PrestiTagihanController::class, 'uploadBukti'])->name('tagihan.upload');
        });
    });
});
