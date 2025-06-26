<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all(); // Ambil semua barang dari database
        // Tentukan halaman berdasarkan route yang dipanggil
        $view = request()->routeIs('homePembeli') ? 'homePembeli' : 'welcome';

        return view($view, compact('barang'));
    }

    public function pegawaiGudang()
    {
         $barang = Barang::with('penitip', 'kategori')->get(); // Ambil semua barang dari database
        return view('pegawaiGudang', compact('barang')); // Kirim data ke tampilan
    }

    // Menyimpan data barang ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'required',
            'deskripsi' => 'required',
            'tanggal_penitipan' => 'required',
            'tanggal_keluar' => 'required',
            'status_penitipan' => 'required',
            'harga_satuan' => 'required|numeric',
            'id_kategori' => 'required|exists:kategori,id',
            'id_pegawai' => 'required|exists:pegawai,id',
            'id_penitip' => 'required|exists:penitip,id',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('images', 'public');
        }

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'gambar' => $gambarPath,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'harga_satuan' => $request->harga_satuan,
            'id_kategori' => $request->id_kategori,
            'id_pegawai' => $request->id_pegawai,
            'id_penitip' => $request->id_penitip,
            'tanggal_penitipan' => $request->tanggal_penitipan,
            'tanggal_keluar' => $request->tanggal_keluar,
            'status_penitipan' => $request->status_penitipan,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Menampilkan satu barang
    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    // Memperbarui data barang
    public function update(Request $request, $id_barang)
    {
        $request->validate([
            'nama_barang' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'required',
            'deskripsi' => 'required',
            'tanggal_penitipan' => 'required',
            'status_penitipan' => 'required',
            'harga_satuan' => 'required|numeric',
            'id_kategori' => 'required|exists:kategori,id',
            'id_pegawai' => 'required|exists:pegawai,id',
            'id_penitip' => 'required|exists:penitip,id',
        ]);

        $barang = Barang::findOrFail($id_barang);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('images', 'public');
            $barang->gambar = $gambarPath;
        }

        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function updateStatus(Request $request, $id_barang)
    {
        $request->validate([
            'status_penitipan' => 'required|in:Diambil,Diperpanjang,Diproses',
        ]);

        // Ambil barang berdasarkan id
        $barang = Barang::findOrFail($id_barang);

        // Jika status diperpanjang, tambahkan 30 hari ke tanggal keluar

        $harga = $barang->harga_satuan * 0.05;

        if($barang->penitip->saldo_penitip >= $harga){
            
            if ($request->status_penitipan === 'Diperpanjang') {
                $tanggalKeluarBaru = \Carbon\Carbon::parse($barang->tanggal_keluar)->addDays(30)->toDateString();
                $barang->tanggal_keluar = $tanggalKeluarBaru;
                $batasAmbil = \Carbon\Carbon::parse($barang->batas_ambil)->addDays(37)->toDateString();
                $barang->batas_ambil = $batasAmbil;
                $barang->penitip->saldo_penitip = $barang->penitip->saldo_penitip - $harga;
                $barang->penitip->save();
            }else {
                return back()->withErrors(['saldo' => 'Saldo tidak mencukupi untuk perpanjangan.']);
            }
        }

        $barang->status_penitipan = $request->status_penitipan;
        $barang->save();
        
        $barangTitipan = Barang::with('kategori')->where('id_penitip', Auth::guard('penitip')->user()->id_penitip)->get();

        return view('homePenitip', compact('id_barang', 'barangTitipan')); // Kirim data ke view
    }


    // Menghapus barang
    public function destroy($id_barang)
    {
        Barang::findOrFail($id_barang)->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }

    // Ambil semua barang untuk API
    public function getAll()
    {
        $barang = Barang::with('kategori')
            ->where('status', 'tersedia')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $barang,
        ]);
    }

}
