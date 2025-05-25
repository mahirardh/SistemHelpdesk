<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RegisterController;
use Livewire\Volt\Volt;

// Routing login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Routing protected dengan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('template.master');
    })->name('home');

    Route::view('dashboard', 'template.dashboard')->name('dashboard');

    // Halaman tambahan (jika bukan controller)
    Route::view('/beranda', 'template.menu')->name('beranda');
    Route::get('/Laporan', [LaporanController::class, 'index'])->name('totalLaporan');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/Selesai', [LaporanController::class, 'selesai'])->name('laporanSelesai');
    Route::get('/laporan/antrian', [LaporanController::class, 'antrian'])->name('antrian');
    Route::get('/laporan/diproses', [LaporanController::class, 'diproses'])->name('proses');
    // Form tambah laporan
    Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    // Form edit status laporan
    Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');

    // Update status laporan
    Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])->name('laporan.update');

    //laporan selesai tabel
    Route::get('/laporan/selesai', [LaporanController::class, 'selesai'])->name('laporan.selesai');
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');



    // Resource User (hindari bentrok)
    Route::resource('users', UserController::class);
});
