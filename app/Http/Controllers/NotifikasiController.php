<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use App\Models\TransaksiPembelian;

class NotifikasiController extends Controller
{
    public function kirimNotifikasiTransaksi(TransaksiPembelian $transaksi)
    {
        // Cari transaksi berdasarkan primary key id_transaksi_pembelian

        if ($transaksi->status_pembelian == 'Diproses') {
            // Update status jadi selesai saat tombol diklik
            $transaksi->status_pembelian = 'selesai';
            $transaksi->save();
        }

        if ($transaksi->status_pembelian == 'selesai') {
            // Notifikasi ke pembeli
            Notifikasi::create([
                'pesan_pembeli' => 'Barang Sudah di ambil, Transaksi  selesai.',
                'pesan_penitip' => 'Barang Anda telah Diambil',
                'id_transaksi_pembelian' => $transaksi->id_transaksi_pembelian,
            ]);

        } elseif ($transaksi->status_pembelian == 'hangus') {
            // Notifikasi ke penitip (barang akan didonasikan)
            Notifikasi::create([
                'pesan_penitip' => 'Barang Anda tidak terjual dan akan didonasikan.',
                'id_transaksi_pembelian' => $transaksi->id_transaksi_pembelian,
            ]);
        }

        return $transaksi;  
    }

    public function kirimWeb($id)
    {
        $transaksi = TransaksiPembelian::findOrFail($id);
        $this->kirimNotifikasiTransaksi($transaksi);
        return redirect()->back()->with('success', 'Notifikasi berhasil dikirim dan status diperbarui.');
    }

    public function kirimApi(Request $request, $id)
    {
        $transaksi = TransaksiPembelian::findOrFail($id);
        $this->kirimNotifikasiTransaksi($transaksi);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dikirim dan status diperbarui.',
            'transaksi' => $transaksi,
        ]);
    }

    public function listApi()
    {
        $notifikasi = Notifikasi::orderBy('id_notifikasi', 'desc')->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifikasi,
        ]);
    }


}
