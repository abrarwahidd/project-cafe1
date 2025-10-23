<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\Kasir\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function (Request $request) {
    if ($request->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($request->user()->role === 'kasir') {
        return redirect()->route('kasir.dashboard');
    }
    // Fallback jika ada role lain atau tidak ada role
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk Pelanggan
Route::get('/meja/{meja:kode_meja}', [PemesananController::class, 'showMenu'])->name('pesan.menu');
Route::post('/pesan', [PemesananController::class, 'store'])->name('pesan.store');
Route::get('/pesanan/sukses/{pesanan:kode_pesanan}', [PemesananController::class, 'showSukses'])->name('pesan.sukses');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Group untuk Admin
// Route Group untuk Admin
Route::middleware(['auth', 'cekrole:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Ini adalah rute yang akan diakses saat login
    Route::get('/dashboard', function () {
        // Mengarahkan admin langsung ke halaman manajemen menu
        return redirect()->route('admin.menus.index');
    })->name('dashboard');

    // Rute untuk CRUD Menu
    Route::resource('menus', MenuController::class);

    // Rute untuk Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

// Route Group untuk Kasir
Route::middleware(['auth', 'cekrole:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // PERBAIKI TITIK MENJADI DUA TITIK DUA DI SINI
    Route::get('/pesanan/{pesanan}', [DashboardController::class, 'show'])->name('pesanan.show');
    // DAN JUGA DI SINI
    Route::post('/pesanan/{pesanan}/validasi', [DashboardController::class, 'validasi'])->name('pesanan.validasi');
});

require __DIR__.'/auth.php';
