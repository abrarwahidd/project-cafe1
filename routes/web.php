<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\Kasir\DashboardController;
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
    return view('welcome');
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
Route::middleware(['auth', 'cekrole:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return "<h1>Ini Halaman Dashboard Admin</h1>";
    })->name('admin.dashboard');

    // Nanti semua route admin lainnya ditaruh di sini
    // Route untuk CRUD Menu
    Route::resource('/admin/menus', MenuController::class);
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
