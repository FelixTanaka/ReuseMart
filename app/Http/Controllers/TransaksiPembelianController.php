<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransaksiPembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Komisi;
use App\Models\Pembeli;
use App\Models\Penitip;
use App\Notifications\TransaksiSelesai;
use App\Services\FirebaseService;


class TransaksiPembelianController extends Controller
{
     protected $firebase;

    public function index()
    {
        $pembeli = auth()->guard('pembeli')->user();
        if (!$pembeli) {
            return redirect()->back()->with('error', 'Pembeli tidak ditemukan');
        }

        $transaksi = TransaksiPembelian::with('barang')
            ->where('id_pembeli', $pembeli->id_pembeli)
            ->get();

        foreach ($transaksi as $t) {
            if (
                true
            ) {
                // Update status transaksi
                $t->status_pembelian = 'hangus';
                $t->save();

                $this->hitungKomisiHunterLangsung($t->id_transaksi_pembelian);

                $barang = Barang::find($t->id_barang); // Pastikan Barang model punya primaryKey = id_barang
                if ($barang) {
                    $barang->status = 'barang untuk donasi';
                    $barang->save();
                } 
            }
        }

        $transaksi = TransaksiPembelian::with(['pembeli', 'barang'])
            ->where('id_pembeli', $pembeli->id_pembeli)
            ->get();

        return view('historyTransaksi', compact('transaksi'));
    }


    // Tambah transaksi pembelian baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'harga_barang' => 'required|numeric',
            'total_harga_transaksi' => 'required|numeric',
            'harga_ongkir' => 'required|numeric',
            'poin_masuk' => 'nullable|integer',
            'poin_keluar' => 'nullable|integer',
            'poin_pembeli' => 'nullable|integer',
            'status_pembelian' => 'required|string',
            'jadwal_pengiriman' => 'nullable|date',
            'metode_pengiriman' => 'required|string',
            'status_pengiriman' => 'required|string',
            'alamat_pengiriman' => 'required|string',
            'id_pembeli' => 'required|exists:pembeli,id',
            'id_pegawai' => 'required|exists:pegawai,id',
            'id_barang' => 'required|exists:barang,id',
        ]);

        $transaksi = TransaksiPembelian::create($request->all());

        $this->hitungKomisiHunterLangsung($transaksi->id_transaksi_pembelian);

        return response()->json($transaksi, 201);
    }

    // Ambil satu transaksi pembelian
    public function show($id)
    {
        $transaksi = TransaksiPembelian::where('id_pembeli', auth()->user()->pembeli->id)->find($id);
        
        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }
        
        return response()->json($transaksi->makeHidden(['id_pembeli', 'id_pegawai']), 200);
    }


    // Perbarui transaksi pembelian
    public function update(Request $request, $id_pembeli)
    {
       $transaksi = TransaksiPembelian::where('id_transaksi_pembelian', $id_pembeli)
            ->where('id_pembeli', $pembeli->id_pembeli)
            ->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $validatedData = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'harga_barang' => 'required|numeric',
            'total_harga_transaksi' => 'required|numeric',
            'harga_ongkir' => 'required|numeric',
            'poin_masuk' => 'nullable|integer',
            'poin_keluar' => 'nullable|integer',
            'poin_pembeli' => 'nullable|integer',
            'status_pembelian' => 'required|string',
            'jadwal_pengiriman' => 'nullable|date',
            'metode_pengiriman' => 'required|string',
            'status_pengiriman' => 'required|string',
            'alamat_pengiriman' => 'required|string',
            'id_pembeli' => 'required|exists:pembeli,id_pembeli',
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'id_barang' => 'required|exists:barang,id_barang',
        ]);

        if (
            $validatedData['status_pembelian'] === 'selesai' &&
            $transaksi->status_pembelian !== 'selesai'
        ) {
            $pembeli = \App\Models\Pembeli::find($validatedData['id_pembeli']);
            dd($pembeli);
            $poinMasuk = intval($validatedData['harga_barang'] / 100000);

            $pembeli->poin_pembeli = ($pembeli->poin_pembeli ?? 0) + $poinMasuk;
            $pembeli->save();

            $validatedData['poin_masuk'] = $poinMasuk;
        }

        $transaksi->update($request->all());

        $this->hitungKomisiHunterLangsung($transaksi->id_transaksi_pembelian);

        return response()->json($transaksi, 200);
    }

    // Hapus transaksi pembelian
    public function destroy($id)
    {
        $transaksi = TransaksiPembelian::where('id_pembeli', auth()->user()->pembeli->id)->find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $transaksi->delete();
        return response()->json(['message' => 'Transaksi berhasil dihapus'], 200);
    }

    public function updateJadwalPengambilan(Request $request, $id)
    {
        $request->validate([
            'jadwal_pengambilan' => 'required|date',
        ]);

        $transaksi = TransaksiPembelian::where('id_transaksi_pembelian', $id)->firstOrFail();
        $transaksi->jadwal_pengambilan = $request->jadwal_pengambilan;
        $transaksi->save();

        return redirect()->route('penjadwalanPengambilan')->with('success', 'Jadwal pengambilan berhasil diperbarui.');
    }

    public function cetakNotaPengambilan($id)
    {
        $transaksi = TransaksiPembelian::with(['pembeli', 'barang'])->where('id_transaksi_pembelian', $id)->firstOrFail();

        $pdf = Pdf::loadView('notaPengambilan', compact('transaksi'));
        return $pdf->stream('notaPengambilan_'.$id.'.pdf');
    }

    public function hitungKomisiHunterLangsung($id_transaksi_pembelian)
    {
        $transaksi = TransaksiPembelian::with('barang') // <-- tambahkan eager loading barang
            ->where('id_transaksi_pembelian', $id_transaksi_pembelian)
            ->whereIn('status_pembelian', ['hangus', 'selesai'])
            ->first();

        if (!$transaksi) {
            return false;
        }

        $harga = $transaksi->harga_barang;

        // Komisi hunter tetap 5%
        $komisiHunter = $harga * 0.05;

        // Komisi ReuseMart 20% atau 30% tergantung status penitipan (diambil dari relasi barang)
        $statusPenitipan = optional($transaksi->barang)->status_penitipan;
        $komisiReuseMart = ($statusPenitipan === 'Diperpanjang') ? $harga * 0.30 : $harga * 0.20;

        Komisi::updateOrCreate(
            ['id_transaksi_pembelian' => $transaksi->id_transaksi_pembelian],
            [
                'komisi_hunter' => $komisiHunter,
                'komisi_reusemart' => $komisiReuseMart,
                'komisi_penitip' => 0
            ]
        );
        return true;
    }

    public function listTransaksiGudang()
    {
        $transaksi = TransaksiPembelian::with(['barang', 'pembeli'])->where('status_pembelian', 'Diproses')->where('metode_pengiriman', 'Diambil')->get();
        return view('transaksi_list', compact('transaksi'));
    }


    public function kirimNotifikasiTransaksi(TransaksiPembelian $transaksi)
    {
        

        return redirect()->back()->with('success', 'Notifikasi berhasil dikirim ke pembeli.');
    }

    public function selesaikan($id){
        $transaksi = TransaksiPembelian::with('pembeli')->findOrFail($id);

        $transaksi->status_pembelian = 'Selesai';
        $transaksi->save();

        $this->hitungKomisiHunterLangsung($id);

        if ($transaksi->pembeli) {
            $hargaBarang = $transaksi->harga_barang;
            $poinPembeliSebelumnya = $transaksi->pembeli->poin_pembeli ?? 0;
            $poinKeluar = $poinPembeliSebelumnya; // Misalnya pembeli pakai semua poin
            $nilaiPoinKeluar = $poinKeluar * 100;

            // Hitung harga setelah dikurangi nilai poin keluar
            $hargaSetelahPoin = $hargaBarang - $nilaiPoinKeluar;

            // Hitung bonus jika harga setelah poin lebih dari 500rb
            $bonus = 0;
            if ($hargaSetelahPoin > 500000) {
                $bonus = ($hargaSetelahPoin / 10000) * 0.2;
            }

            // Total poin yang akan masuk
            $poinMasuk = floor($bonus + ($hargaSetelahPoin / 10000));

            // Tambah poin ke pembeli
            $transaksi->poin_keluar = $poinKeluar;
            $transaksi->poin_masuk = $poinMasuk;
            $transaksi->save();

            // Update poin pembeli: kurangi poin keluar, tambah poin masuk
            $transaksi->pembeli->poin_pembeli = $poinPembeliSebelumnya - $poinKeluar + $poinMasuk;
            $transaksi->pembeli->save();
        }

        return redirect()->back()->with('success', 'Transaksi berhasil diselesaikan.');
    }

}
