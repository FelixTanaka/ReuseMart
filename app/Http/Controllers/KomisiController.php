<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Komisi;
use App\Models\TransaksiPembelian;
use Illuminate\Support\Facades\Auth;


class KomisiController extends Controller
{
    public function hitungKomisiHunter($id_barang)
    {
        $barang = Barang::findOrFail($id_barang);

        // Pastikan barang sudah terjual
        if ($barang->status !== 'terjual') {
            return response()->json([
                'message' => 'Barang belum terjual. Komisi belum bisa dihitung.'
            ], 400);
        }

        // Ambil harga
        $harga = $barang->harga_satuan;

        // Komisi hunter tetap 5% (baik perpanjang atau tidak)
        $komisiHunter = $harga * 0.05;

        // Ambil id transaksi pembelian
        $transaksi = TransaksiPembelian::where('id_barang', $barang->id)->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi pembelian tidak ditemukan.'], 404);
        }

        // Simpan komisi
        Komisi::create([
            'komisi_hunter' => $komisiHunter,
            'komisi_reusemart' => 0,
            'komisi_penitip' => 0,
            'id_transaksi_pembelian' => $transaksi->id
        ]);


        return response()->json([
            'message' => 'Komisi Hunter berhasil disimpan.',
            'komisi_hunter' => $komisiHunter,
            'status_penitipan' => $barang->status_penitipan
        ]);
    }

    public function komisiHistory()
    {
        $idPegawai = Auth::user()->id_pegawai;

        $komisis = Komisi::with(['pegawai', 'transaksipembelian'])
                ->where('id_pegawai', $idPegawai)
                ->orderBy('id_komisi')
                ->get();



        $history = $komisis->map(function ($komisi) {

            return [
                'nama' => $komisi->pegawai->nama_pegawai ?? 'Tidak diketahui',
                'komisi' => $komisi->komisi_hunter,
                'tanggal_transaksi' => $komisi->transaksipembelian->tanggal_transaksi ?? 'Tidak ada',
                'nama_barang' => $komisi->transaksipembelian->barang->nama_barang ?? 'Tidak diketahui',
                'harga_barang' => $komisi->transaksipembelian->harga_barang ?? 0,
            ];
        });

        return response()->json([
            'data' => $history
        ]);
    }



}
