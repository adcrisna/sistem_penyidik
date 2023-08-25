<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenyidikController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AdminController;

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
Route::any('/logout', [AdminController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::prefix('penyidik')->middleware(['penyidik'])->group(function () {
        Route::any('/home', [PenyidikController::class, 'index'])->name('penyidik_home');
        Route::any('/profile', [PenyidikController::class, 'profile'])->name('penyidik_profile');
        Route::any('/print_profile', [PenyidikController::class, 'print_profile'])->name('print_profile');
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
        Route::any('/print_kasus', [PenyidikController::class, 'print_kasus'])->name('print_kasus');

        Route::any('/penyerahan_bukti', [PenyidikController::class, 'penyerahan_bukti'])->name('penyerahan_bukti');
        Route::any('/detail_bukti{id}', [PenyidikController::class, 'detail_bukti'])->name('detail_bukti');
        Route::any('/edit_bukti', [PenyidikController::class, 'edit_bukti'])->name('edit_bukti');
        Route::any('/print_penyerahan', [PenyidikController::class, 'print_penyerahan'])->name('print_penyerahan');
        Route::any('/selesai_kasus', [PenyidikController::class, 'selesai'])->name('selesai');
        Route::any('/pengembalian_bukti', [PenyidikController::class, 'pengembalian_bukti'])->name('pengembalian_bukti');
        Route::any('/data_pengembalian', [PenyidikController::class, 'data_pengembalian'])->name('data_pengembalian');
        Route::any('/print_pengembalian', [PenyidikController::class, 'print_pengembalian'])->name('print_pengembalian');
        
        Route::any('/history', [PenyidikController::class, 'history'])->name('history');
        Route::any('/kasus_selesai', [PenyidikController::class, 'kasus_selesai'])->name('kasus_selesai');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::any('/home', [AdminController::class, 'index'])->name('admin_home');
        Route::any('/profile_admin', [AdminController::class, 'profile'])->name('admin_profile');
        Route::any('/update_admin', [AdminController::class, 'update_profile'])->name('update_admin');
        Route::any('/data_user', [AdminController::class, 'data_user'])->name('data_user');

        Route::any('/tambah_user', [AdminController::class, 'tambah_user'])->name('tambah_user');
        Route::any('/update_user', [AdminController::class, 'update_user'])->name('update_user');
        Route::any('/delete_user{id}', [AdminController::class, 'delete_user'])->name('delete_user');

        Route::any('/kasus', [AdminController::class, 'kasus'])->name('kasus');
        Route::any('/bukti', [AdminController::class, 'bukti'])->name('bukti');
        Route::any('/data_history', [AdminController::class, 'data_history'])->name('data_history');
        Route::any('/data_selesai', [AdminController::class, 'data_selesai'])->name('data_selesai');
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