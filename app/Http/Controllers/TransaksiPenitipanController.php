<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenitipan;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TransaksiPenitipanController extends Controller{ 
    public function index()
    {
        $transaksi = TransaksiPenitipan::with(['barang', 'pegawai'])->get();
        return response()->json($transaksi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'bonus' => 'nullable|numeric',
            'total_penghasilan' => 'nullable|numeric',
        ]);

        $transaksi = TransaksiPenitipan::create($request->all());

        return response()->json(['message' => 'Transaksi berhasil dibuat', 'transaksi' => $transaksi], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_penitip' => 'nullable|exists:barang,id_barang',
            'id_pegawai' => 'nullable|exists:pegawai,id_pegawai',
            'bonus' => 'nullable|numeric',
            'total_penghasilan' => 'nullable|numeric',
        ]);

        $transaksi = TransaksiPenitipan::findOrFail($id);
        $transaksi->update($request->all());

        return response()->json(['message' => 'Transaksi berhasil diperbarui', 'transaksi' => $transaksi]);
    }

    public function destroy($id)
    {
        TransaksiPenitipan::destroy($id);
        return response()->json(['message' => 'Transaksi berhasil dihapus']);
    }

    public function hitungPenghasilanPenitip(TransaksiPenitipan $transaksi)
    {
        $hargaSatuan = $transaksi->barang->harga_satuan ?? 0;
        $statusPenitipan = strtolower($transaksi->status_penitipan ?? '');

        // Hitung pengurangan berdasarkan status
        if ($statusPenitipan === 'Diperpanjang') {
            $total_penghasilan = $hargaSatuan - ($hargaSatuan * 0.30);
        } else {
            $total_penghasilan = $hargaSatuan - ($hargaSatuan * 0.20);
        }

        // Cek bonus jika < 7 hari
        $tanggalPenitipan = Carbon::parse($transaksi->barang->tanggal_penitipan)->startOfDay();
        $tanggalKeluar = Carbon::parse($transaksi->barang->tanggal_keluar ?? now())->startOfDay();
        $selisihHari = $tanggalPenitipan->diffInDays($tanggalKeluar);

        $bonus = 0;
        if ($selisihHari < 7) {
            $bonus = $hargaSatuan * 0.20 * 0.10;
        }

        $total_penghasilan = $total_penghasilan + $bonus;

        // Simpan bonus & penghasilan ke database (pastikan ada kolom 'bonus' dan 'penghasilan')
        $transaksi->bonus = $bonus;
        $transaksi->total_penghasilan = $total_penghasilan;
        $transaksi->save();

        if ($transaksi->barang && $transaksi->barang->penitip) {
            $penitip = $transaksi->barang->penitip ?? null;
            $penitip->saldo_penitip = ($penitip->saldo_penitip ?? 0) + $total_penghasilan;
            $penitip->save();
        }

        return $total_penghasilan;
    }


    public function showDashboard()
    {
        $transaksis = TransaksiPenitipan::with(['barang', 'pegawai'])->get();

        return view('dashboard.cs', ['transaksis' => $transaksis]);
    }

    public function selesaikan($id)
    {
        $transaksi = TransaksiPenitipan::with('barang.penitip')->findOrFail($id);

        // Ubah status penitipan menjadi 'Selesai'
        $transaksi->barang->status_penitipan = 'Selesai';
        $transaksi->barang->save();

        // Hitung dan simpan penghasilan + saldo penitip
        $this->hitungPenghasilanPenitip($transaksi);

        return redirect()->back()->with('success', 'Transaksi penitipan berhasil diselesaikan.');
    }

}

