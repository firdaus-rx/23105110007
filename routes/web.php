<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Cetak rapor (all roles)
Route::get('/rapor/{rapor}/cetak', [App\Http\Controllers\RaporController::class, 'cetak'])->name('rapor.cetak')->middleware('auth');

// Group Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('guru', App\Http\Controllers\Admin\GuruController::class);
    Route::resource('kelas', App\Http\Controllers\Admin\KelasController::class)->parameters(['kelas' => 'kelas']);
    Route::resource('siswa', App\Http\Controllers\Admin\SiswaController::class);
    Route::resource('mata-pelajaran', App\Http\Controllers\Admin\MataPelajaranController::class);
    Route::resource('tahun-pelajaran', App\Http\Controllers\Admin\TahunPelajaranController::class);
    Route::resource('semester', App\Http\Controllers\Admin\SemesterController::class);
    Route::resource('jadwal-mengajar', App\Http\Controllers\Admin\JadwalMengajarController::class);
    Route::resource('nilai-rapor', App\Http\Controllers\Admin\NilaiRaporController::class);
    Route::get('get-siswa-by-kelas/{kelas}', [App\Http\Controllers\Admin\AbsensiController::class, 'getSiswaByKelas'])->name('get-siswa-by-kelas');
    Route::get('nilai-rapor/get-siswa/{kelas}', [App\Http\Controllers\Admin\NilaiRaporController::class, 'getSiswaByKelas'])->name('nilai-rapor.get-siswa');
    Route::resource('absensi', App\Http\Controllers\Admin\AbsensiController::class);
    Route::get('rapor/get-siswa/{kelas}', [App\Http\Controllers\Admin\RaporController::class, 'getSiswaByKelas'])->name('rapor.get-siswa');
    Route::get('rapor/get-data/{siswa}', [App\Http\Controllers\Admin\RaporController::class, 'getRaporData'])->name('rapor.get-data');
    Route::get('kenaikan-kelas', [App\Http\Controllers\Admin\KenaikanKelasController::class, 'index'])->name('admin.kenaikan-kelas');
    Route::get('kenaikan-kelas/preview', [App\Http\Controllers\Admin\KenaikanKelasController::class, 'preview'])->name('admin.kenaikan-kelas.preview');
    Route::post('kenaikan-kelas/promote', [App\Http\Controllers\Admin\KenaikanKelasController::class, 'promote'])->name('admin.kenaikan-kelas.promote');
    Route::resource('rapor', App\Http\Controllers\Admin\RaporController::class);
});

// Group Guru
Route::prefix('guru')->middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/', [App\Http\Controllers\Guru\DashboardController::class, 'index'])->name('guru.dashboard');
    Route::get('jadwal', [App\Http\Controllers\Guru\DashboardController::class, 'jadwal'])->name('guru.jadwal');
    Route::get('nilai/{jadwal}', [App\Http\Controllers\Guru\NilaiController::class, 'index'])->name('guru.nilai.index');
    Route::post('nilai/{jadwal}', [App\Http\Controllers\Guru\NilaiController::class, 'store'])->name('guru.nilai.store');
    Route::get('rekap', [App\Http\Controllers\Guru\NilaiController::class, 'rekap'])->name('guru.nilai.rekap');
    // Wali kelas
    Route::get('wali-kelas', [App\Http\Controllers\Guru\WaliKelasController::class, 'index'])->name('guru.wali.index');
    Route::get('wali-kelas/absensi', [App\Http\Controllers\Guru\WaliKelasController::class, 'absensi'])->name('guru.wali.absensi');
    Route::post('wali-kelas/absensi', [App\Http\Controllers\Guru\WaliKelasController::class, 'storeAbsensi'])->name('guru.wali.absensi.store');
    Route::get('wali-kelas/rapor', [App\Http\Controllers\Guru\WaliKelasController::class, 'rapor'])->name('guru.wali.rapor');
    Route::put('wali-kelas/rapor/{rapor}', [App\Http\Controllers\Guru\WaliKelasController::class, 'updateRapor'])->name('guru.wali.rapor.update');
    Route::post('wali-kelas/rapor/{rapor}/finalisasi', [App\Http\Controllers\Guru\WaliKelasController::class, 'finalisasi'])->name('guru.wali.rapor.finalisasi');
});

// Group Siswa / Orang Tua
Route::prefix('siswa')->middleware(['auth', 'role:siswa,orang_tua'])->group(function () {
    Route::get('/', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('siswa.dashboard');
    Route::get('nilai', [App\Http\Controllers\Siswa\DashboardController::class, 'nilai'])->name('siswa.nilai');
    Route::get('rapor', [App\Http\Controllers\Siswa\DashboardController::class, 'rapor'])->name('siswa.rapor');
    Route::get('rapor/{rapor}/cetak', [App\Http\Controllers\Siswa\DashboardController::class, 'cetakRapor'])->name('siswa.rapor.cetak');
});
