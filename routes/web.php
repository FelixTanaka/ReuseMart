<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\TransaksiPembelianController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengirimanBarangController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\TransaksiPenitipanController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\RequestDonasiController;

Route::get('/', [BarangController::class, 'index'])->name('welcome');

Route::get('/profilePembeli', [PembeliController::class, 'showProfile'])->middleware('auth:pembeli')->name('profilePembeli');
Route::get('/historyTransaksi', [TransaksiPembelianController::class, 'index'])->middleware('auth:pembeli')->name('historyTransaksi');

Route::post('/register', [LoginController::class, 'register'])->name('register.submit');
Route::post('/login', [LoginController::class, 'loginWeb'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/homePembeli', [PembeliController::class, 'home'])->middleware('auth:pembeli')->name('homePembeli');
Route::get('/homePenitip', [PenitipController::class, 'home'])->middleware('auth:penitip')->name('homePenitip');

Route::middleware('auth:pegawai')->group(function () {
    Route::get('/dashboard/{halaman?}', [PegawaiController::class, 'dashboard'])->name('pegawai.dashboard');
});

Route::get('/cetak-laporan-kategori', [PegawaiController::class, 'cetakLaporanKategori'])->name('cetak.laporan.kategori');

Route::get('/pegawai/laporan-penitipan/pdf', [PegawaiController::class, 'cetakLaporanPenitipan'])->name('pegawai.laporan-penitipan.pdf');

Route::get('/customerService/transaksi', [TransaksiPenitipanController::class, 'showDashboard'])->name('dasboard.cs');

Route::put('/pengiriman/{id_pengiriman}', [PengirimanBarangController::class, 'update'])->name('pengiriman.update');

Route::get('/pengiriman', [PengirimanBarangController::class, 'store'])->name('pengiriman');

Route::get('/pengirimanBarang/{id}/cetakNota', [PegawaiController::class, 'cetakNota'])->name('pengiriman.cetakNota');

Route::put('/barang/{id_barang}/status', [BarangController::class, 'updateStatus'])->name('barang.updateStatus');

Route::put('/jadwal_pengambilan/{id}', [TransaksiPembelianController::class, 'updateJadwalPengambilan'])->name('updateJadwalPengambilan');
Route::get('/cetakNota/{id}', [TransaksiPembelianController::class, 'cetakNotaPengambilan'])->name('cetakNotaPengambilan');

Route::get('/komisi/hunter/{id}', [TransaksiPembelianController::class, 'hitungKomisiHunterLangsung']);

Route::get('/gudang/transaksi', [TransaksiPembelianController::class, 'listTransaksiGudang'])->name('gudang.transaksi');

// Kirim notifikasi
Route::post('/transaksi/{id}/kirim-notifikasi', [TransaksiPembelianController::class, 'kirimNotifikasi'])->name('notifikasi.kirimTransaksi');

// Selesaikan transaksi
// Untuk transaksi pembelian
Route::put('/transaksi/{id}/selesai', [TransaksiPembelianController::class, 'selesaikan'])->name('transaksiPembelian.selesai');

// Untuk transaksi penitipan
Route::put('/penitipan/{id}/selesai', [TransaksiPenitipanController::class, 'selesaikan'])->name('transaksiPenitipan.selesai');

Route::post('/penitip/store', [PenitipController::class, 'store'])->name('penitip.store');
// Menampilkan form edit
Route::get('/penitip/{id}/edit', [PenitipController::class, 'edit'])->name('penitip.edit');
// Menyimpan hasil edit
Route::put('/penitip/{id}', [PenitipController::class, 'update'])->name('penitip.update');

Route::delete('/penitip/{id}', [PenitipController::class, 'destroy'])->name('penitip.destroy');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/register', function () {
    return view('register');
})->name('register.form');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/organisasi', [RequestDonasiController::class, 'index'])->middleware('auth:organisasi')->name('organisasiView');
Route::post('/request-donasi', [RequestDonasiController::class, 'store'])->name('request.store');
Route::put('/request-donasi/{id}', [RequestDonasiController::class, 'update'])->name('request.update');
Route::delete('/request-donasi/{id}', [RequestDonasiController::class, 'destroy'])->name('request.destroy');



Route::put('/pembeli/{id}', [PembeliController::class, 'update'])->name('pembeli.update');


