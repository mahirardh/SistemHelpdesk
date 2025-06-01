<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Routing login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routing register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


// Routing yang dilindungi auth
Route::middleware(['auth'])->group(function () {

    // Halaman awal
    Route::get('/', function () {
        return redirect()->route('beranda');
    });

    Route::view('/dashboard', 'template.dashboard')->name('dashboard');
    Route::get('/beranda', [DashboardController::class, 'index'])->name('beranda');
    // Routing laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');           // Tampil semua laporan
    Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');   // Form tambah laporan
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');           // Simpan laporan
    Route::get('/laporan/selesai', [LaporanController::class, 'selesai'])->name('laporanSelesai'); // Tabel laporan selesai
    Route::get('/laporan/antrian', [LaporanController::class, 'antrian'])->name('antrian');        // Laporan status open
    Route::get('/laporan/diproses', [LaporanController::class, 'diproses'])->name('proses');       // Laporan in progress
    Route::put('/laporan/close/{id}', [LaporanController::class, 'close'])->name('laporan.close');


    // Form edit status laporan
    Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])->name('laporan.update');

    // ✅ Route untuk menyimpan catatan penyelesaian (dari modal popup)
    Route::put('/laporan/{id}/catatan', [LaporanController::class, 'updateCatatan'])->name('laporan.updateCatatan');

    // Detail laporan (route dinamis taruh di paling bawah)
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');

    // Total laporan (alias ke index, bisa dihapus jika tidak perlu)
    Route::get('/Laporan', [LaporanController::class, 'index'])->name('totalLaporan');

    // CRUD user
    Route::resource('users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'show'])
        ->middleware('auth')
        ->name('profile.show');

    //SOP prioritas
    Route::get('/aturan-prioritas', function () {
        return view('template.aturan_prioritas'); // ini adalah view berisi PDF atau gambar aturan
    })->name('prioritas.aturan');
});
