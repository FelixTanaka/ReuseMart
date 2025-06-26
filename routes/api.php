<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TransaksiPenitipanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiPembelianController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PengirimanBarangController;
use App\Http\Controllers\KomisiController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\TransaksiMerchandiseController;

Route::post('/login', [LoginController::class, 'loginApi']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

Route::get('/homePembeli', [PembeliController::class, 'home'])->middleware('auth:pembeli')->name('api.homePembeli');
Route::get('/homePenitip', [PenitipController::class, 'home'])->middleware('auth:penitip')->name('api.homePenitip');

Route::get('/profilePembeli', [PembeliController::class, 'showProfile'])->name('profilePembeli');
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/pembeli/{id}', [PembeliController::class, 'update'])->name('pembeli.update');
});

Route::post('/fcm-token', [PembeliController::class, 'simpanFcmToken']);


Route::post('/penitip', [PenitipController::class, 'store'])->name('penitip.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/penitip', [PenitipController::class, 'index'])->name('penitip.index');
    Route::get('/penitip/{id}', [PenitipController::class, 'search'])->name('penitip.search');
    Route::put('/penitip/{id}', [PenitipController::class, 'update'])->name('penitip.update');
    Route::delete('/penitip/{id}', [PenitipController::class, 'destroy'])->name('penitip.destroy');
});

Route::get('/role', [RoleController::class, 'index'])->name('role.index');

Route::post('/organisasi/login', [OrganisasiController::class, 'login'])->name('organisasi.login');
Route::post('/organisasi/logout', [OrganisasiController::class, 'logout'])->middleware('auth:sanctum')->name('organisasi.logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/organisasi', [OrganisasiController::class, 'index'])->name('organisasi.index');
    Route::get('/organisasi/{id}', [OrganisasiController::class, 'search'])->name('organisasi.search');
    Route::put('/organisasi/{id}', [OrganisasiController::class, 'update'])->name('organisasi.update');
    Route::delete('/organisasi/{id}', [OrganisasiController::class, 'destroy'])->name('organisasi.destroy');
});

Route::post('/pegawai/register', [PegawaiController::class, 'register'])->name('pegawai.register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawai.show');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store'); 
    Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    Route::get('/hunter/profile', [PegawaiController::class, 'profileHunter']);
    Route::get('/hunter/komisi-history', [KomisiController::class, 'komisiHistory']);

});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/transaksi', [TransaksiPenitipanController::class, 'index']); 
    Route::post('/transaksi', [TransaksiPenitipanController::class, 'store']); 
    Route::put('/transaksi/{id}', [TransaksiPenitipanController::class, 'update']); 
    Route::delete('/transaksi/{id}', [TransaksiPenitipanController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->get('/merchandise', [MerchandiseController::class, 'index']);


Route::get('/barang', [BarangController::class, 'getAll']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::put('/barang/{id_barang}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id_barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::put('/barang/{id_barang}/status', [BarangController::class, 'updateStatus'])->name('barang.updateStatus');
});

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');
Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');


Route::get('/transaksi-pembelian', [TransaksiPembelianController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi-pembelian', [TransaksiPembelianController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi-pembelian/{id}', [TransaksiPembelianController::class, 'show'])->name('transaksi.show');
Route::put('/transaksi-pembelian/{id}', [TransaksiPembelianController::class, 'update'])->name('transaksi.update');
Route::delete('/transaksi-pembelian/{id}', [TransaksiPembelianController::class, 'destroy'])->name('transaksi.destroy');


Route::get('/pengiriman', [PengirimanBarangController::class, 'index']); 
Route::post('/pengiriman', [PengirimanBarangController::class, 'store']); 
Route::get('/pengiriman/{id}', [PengirimanBarangController::class, 'show']); 
Route::put('/pengiriman/{id}', [PengirimanBarangController::class, 'update']); 
Route::delete('/pengiriman/{id}', [PengirimanBarangController::class, 'destroy']);

Route::post('/notifikasi/kirim/{id}', [NotifikasiController::class, 'kirimApi']);
Route::get('/transaksi/list', [NotifikasiController::class, 'listApi']);

Route::middleware('auth:sanctum')->post('/tukar-merchandise', [TransaksiMerchandiseController::class, 'tukar']);

