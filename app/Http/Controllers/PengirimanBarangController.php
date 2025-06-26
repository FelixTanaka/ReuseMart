<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengirimanBarang;

class PengirimanBarangController extends Controller
{
    public function index()
    {
        $pengiriman = PengirimanBarang::all();
        return view('pengiriman.index', compact('pengiriman'));
    }

    // Menampilkan form untuk membuat pengiriman barang baru
    public function create()
    {
        return view('pengiriman.create');
    }

    // Menyimpan data pengiriman barang ke database
    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'nullable|exists:pegawais,id',
            'id_transaksi_pembelian' => 'required|exists:transaksi_pembelian,id',
        ]);

        PengirimanBarang::create($request->all());

        return redirect()->route('pengiriman.index')->with('success', 'Pengiriman barang berhasil ditambahkan!');
    }

    // Menampilkan detail pengiriman barang berdasarkan ID
    public function show($id)
    {
        $pengiriman = PengirimanBarang::findOrFail($id);
        return view('pengiriman.show', compact('pengiriman'));
    }

    // Menampilkan form untuk mengedit pengiriman barang
    public function edit($id)
    {
        $pengiriman = PengirimanBarang::findOrFail($id);
        return view('pengiriman.edit', compact('pengiriman'));
    }

    // Memperbarui data pengiriman barang
    public function update(Request $request, $id_pengiriman)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'jadwal_pengiriman' => 'required|date',
        ]);

        $pengiriman = PengirimanBarang::findOrFail($id_pengiriman);
        $pengiriman->id_pegawai = $request->id_pegawai;
        $pengiriman->transaksiPembelian->jadwal_pengiriman = $request->jadwal_pengiriman;
        $pengiriman->transaksiPembelian->save();
        $pengiriman->save();

        return redirect()->route('pegawai.dashboard', 'penjadwalan-pengiriman')
                 ->with('success', 'Kurir berhasil ditugaskan!');
    }


    // Menghapus data pengiriman barang
    public function destroy($id)
    {
        $pengiriman = PengirimanBarang::findOrFail($id);
        $pengiriman->delete();

        return redirect()->route('pengiriman.index')->wxith('success', 'Pengiriman barang berhasil dihapus!');
    }
}
