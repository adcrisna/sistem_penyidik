<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenyidikController;
use App\Http\Controllers\PetugasController;

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

Route::any('/', [LoginController::class, 'index'])->name('index');
Route::any('/proses_login', [LoginController::class, 'prosesLogin'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::prefix('penyidik')->middleware(['penyidik'])->group(function () {
        Route::any('/home', [PenyidikController::class, 'index'])->name('penyidik_home');
        Route::any('/profile', [PenyidikController::class, 'profile'])->name('penyidik_profile');
        Route::any('/update_profile', [PenyidikController::class, 'update_profile'])->name('update_profile');
        Route::any('/logout', [PenyidikController::class, 'logout'])->name('penyidik_logout');

        Route::any('/data_petugas', [PenyidikController::class, 'data_petugas'])->name('data_petugas');
        Route::any('/tambah_petugas', [PenyidikController::class, 'tambah_petugas'])->name('tambah_petugas');
        Route::any('/update_petugas', [PenyidikController::class, 'update_petugas'])->name('update_petugas');
        Route::any('/delete_petugas{id}', [PenyidikController::class, 'delete_petugas'])->name('delete_petugas');
        Route::any('/print_petugas', [PenyidikController::class, 'print_petugas'])->name('print_petugas');

        Route::any('/data_kasus', [PenyidikController::class, 'data_kasus'])->name('data_kasus');
        Route::any('/detail_kasus{id}', [PenyidikController::class, 'detail_kasus'])->name('detail_kasus');
        Route::any('/tambah_kasus', [PenyidikController::class, 'tambah_kasus'])->name('tambah_kasus');
        Route::any('/update_kasus', [PenyidikController::class, 'update_kasus'])->name('update_kasus');
        Route::any('/delete_kasus{id}', [PenyidikController::class, 'delete_kasus'])->name('delete_kasus');

        Route::any('/penyerahan_bukti', [PenyidikController::class, 'penyerahan_bukti'])->name('penyerahan_bukti');
        Route::any('/selesai_kasus{id}', [PenyidikController::class, 'selesai'])->name('selesai');
        Route::any('/pengembalian_bukti', [PenyidikController::class, 'pengembalian_bukti'])->name('pengembalian_bukti');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('petugas')->middleware(['petugas'])->group(function () {
        Route::any('/home', [PetugasController::class, 'index'])->name('petugas_home');
        Route::any('/logout', [PetugasController::class, 'logout'])->name('petugas_logout');
        Route::any('/profile_petugas', [PetugasController::class, 'profile_petugas'])->name('profile_petugas');

        Route::any('/data_bukti', [PetugasController::class, 'data_bukti'])->name('data_bukti');
        Route::any('/proses_bukti{id}', [PetugasController::class, 'proses_bukti'])->name('proses_bukti');
        Route::any('/tambah_bukti', [PetugasController::class, 'tambah_bukti'])->name('tambah_bukti');
        Route::any('/update_bukti', [PetugasController::class, 'update_bukti'])->name('update_bukti');
        Route::any('/delete_bukti{id}', [PetugasController::class, 'delete_bukti'])->name('delete_bukti');
    });
});