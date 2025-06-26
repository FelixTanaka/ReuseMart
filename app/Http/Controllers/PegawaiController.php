<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pegawai;
use App\Models\Role;
use App\Models\Barang;
use App\Models\Penitip;
use App\Models\TransaksiPembelian;
use APp\Models\Pembeli;
use App\Models\PengirimanBarang;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\TransaksiPenitipan;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        return response()->json($pegawai);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'email_pegawai' => 'required|email|unique:pegawai|max:255',
            'password_pegawai' => 'required|min:6', 
            'no_telp_pegawai' => 'required|numeric|digits_between:10,13',
            'alamat_pegawai' => 'required|string|min:10',
            'id_role' => 'required|integer|exists:role,id_role',
        ]);

        // Simpan data pegawai terlebih dahulu
        $pegawai = Pegawai::create([
            'nama_pegawai' => $request->nama_pegawai,
            'no_telp_pegawai' => $request->no_telp_pegawai,
            'password_pegawai' => Hash::make($request->password_pegawai),
            'email_pegawai' => $request->email_pegawai,
            'alamat_pegawai' => $request->alamat_pegawai,
            'id_role' => $request->id_role,
        ]);

        // Pastikan data sudah masuk sebelum mengakses id_role
        if (!$pegawai || !$pegawai->id_role) {
            return response()->json(['message' => 'Error: Role not assigned'], 400);
        }

        return response()->json(['message' => 'Pegawai successfully registered', 'pegawai' => $pegawai], 201);
    }

    public function show($id)
    {
        $pegawai = Pegawai::find($id);
        return response()->json($pegawai);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->update($request->all());

        return response()->json($pegawai);
    }

    public function destroy($id)
    {
        Pegawai::destroy($id);
        return response()->json(['message' => 'Pegawai deleted']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'email_pegawai' => 'required|email|unique:pegawai|max:255',
            'password_pegawai' => 'required|min:6',
            'no_telp_pegawai' => 'required|numeric|digits_between:10,13',
            'alamat_pegawai' => 'required|string|min:10',
            'id_role' => 'required|integer|exists:role,id_role',
        ]);

        $pegawai = Pegawai::create([
            'nama_pegawai' => $request->nama_pegawai,
            'no_telp_pegawai' => $request->no_telp_pegawai,
            'password_pegawai' => Hash::make($request->password_pegawai),
            'email_pegawai' => $request->email_pegawai,
            'alamat_pegawai' => $request->alamat_pegawai,
            'id_role' => $request->id_role,
        ]);

        return response()->json(['message' => 'Pegawai successfully registered', 'pegawai' => $pegawai], 201);
    }

     public function cetakNota($id)
    {
        $pengiriman = PengirimanBarang::with(['pegawai', 'transaksiPembelian.pembeli'])->findOrFail($id);

        $pdf = Pdf::loadView('notaPengiriman', compact('pengiriman'));
        return $pdf->stream('notaPengiriman_' . $id . '.pdf');
    }


    public function dashboard($halaman = null)
    {
        $pegawai = Auth::guard('pegawai')->user();

        if (!$pegawai) {
            return redirect()->route('login')->withErrors(['message' => 'Silakan login terlebih dahulu']);
        }

        $data = ['pegawai' => $pegawai];
        $message = 'Selamat datang, ';

        switch ($pegawai->id_role) {
            case 1:
                $message .= 'Owner!';
                switch ($halaman) {
                    case 'laporan-kategori':
                        $data['laporan_kategori'] = DB::table('kategoribarang as k')
                            ->select('k.nama_kategori',
                                DB::raw('SUM(CASE WHEN b.status = "terjual" THEN 1 ELSE 0 END) as jumlah_terjual'),
                                DB::raw('SUM(CASE WHEN b.status = "didonasikan" THEN 1 ELSE 0 END) as jumlah_didonasikan')
                            )
                            ->leftJoin('barang as b', 'k.id_kategori', '=', 'b.id_kategori')
                            ->groupBy('k.id_kategori', 'k.nama_kategori')
                            ->get();

                        return view('laporankategori', $data)->with('message', $message);

                    case 'laporan-penitipan':
                        $data['laporan_penitipan'] = DB::table('barang as b')
                            ->select('b.id_barang','b.nama_barang', 'b.id_penitip', 'b.tanggal_penitipan', 'b.tanggal_keluar', 'b.status_penitipan', 'p.nama_penitip as nama_penitip')
                            ->leftJoin('penitip as p', 'b.id_penitip', '=', 'p.id_penitip')
                            ->where('b.status_penitipan', 'habis')
                            ->get();

                        return view('laporanpenitipan', $data)->with('message', $message);    

                    default:
                        return view('ownerview', $data)->with('message', $message);
                }

            case 2:
                switch ($halaman) {
                    case 'pencatatan-barang':
                        $data['barang'] = Barang::with('penitip')->get();
                        return view('pencatatanPengambilanBarang', $data)->with('message', 'Selamat datang, Gudang!');
                    case 'transaksi-pembeli':
                        $data['transaksi_pembelian'] = TransaksiPembelian::with('pembeli')->get();
                        return view('daftarTransaksiPegawai', $data)->with('message', 'Selamat datang, Gudang!');
                    case 'penjadwalan-pengiriman':
                        $data['pengiriman'] = PengirimanBarang::with(['transaksiPembelian.pembeli', 'pegawai'])->get();
                        $data['listPegawai'] = Pegawai::all();
                        return view('penjadwalanPengiriman', $data)->with('message', 'Selamat datang, Gudang!');
                    case 'penjadwalan-pengambilan':
                        $data['transaksi_pembelian'] = TransaksiPembelian::with('pembeli')->get();
                        return view('penjadwalanPengambilan', $data)->with('message', 'Selamat datang, Gudang!');
                    case 'transaksi-diambil':
                        $data['transaksi'] = TransaksiPembelian::with(['barang', 'pembeli'])
                            ->where('status_pembelian', 'Diproses')
                            ->where('metode_pengiriman', 'Diambil')
                            ->get();
                        return view('transaksi_list', $data)->with('message', 'Selamat datang, Gudang!');    
                    default:
                        $data['barang'] = Barang::with('penitip')->get();
                        return view('pegawaiGudang', $data)->with('message', 'Selamat datang, Gudang!');
                }

            case 3:
                switch ($halaman) {
                    case 'daftar-penitip':
                        $data['penitip'] = Penitip::all();
                        return view('daftarPenitip', $data)->with('message', $message);
                    default:
                        $data['transaksis'] = TransaksiPenitipan::with(['barang', 'pegawai'])->get();
                        return view('customerService', $data)->with('message', $message);
                }

            case 4:
                return view('dashboardKeuangan', $data)->with('message', 'Selamat datang, Keuangan!');

            default:
                return view('home')->withErrors(['message' => 'Role tidak dikenali']);
        }
    }


    public function profileHunter()
    {
        $pegawai = Auth::user();

        // Cek apakah pegawai login dan apakah rolenya "Hunter"
        if (!$pegawai) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Misalnya role Hunter itu id_role = 5 (ganti sesuai ID sebenarnya)
        if ($pegawai->id_role != 4) {
            return response()->json(['message' => 'Anda bukan Hunter'], 403);
        }

        $komisiList = $pegawai->komisi;

        $totalKomisi = $komisiList->sum('komisi_hunter');

        return response()->json([
            'nama' => $pegawai->nama_pegawai,
            'email' => $pegawai->email_pegawai,
            'no_telp' => $pegawai->no_telp_pegawai,
            'alamat' => $pegawai->alamat_pegawai,
            'total_komisi' => $totalKomisi,
        ]);
    }

    public function cetakLaporanKategori()
    {
        $laporan = DB::table('kategoribarang as k')
            ->leftJoin('barang as b', 'k.id_kategori', '=', 'b.id_kategori')
            ->select(
                'k.nama_kategori',
                DB::raw('SUM(CASE WHEN b.status = "terjual" THEN 1 ELSE 0 END) as jumlah_terjual'),
                DB::raw('SUM(CASE WHEN b.status = "didonasikan" THEN 1 ELSE 0 END) as jumlah_didonasikan')
            )
            ->groupBy('k.id_kategori', 'k.nama_kategori')
            ->get();

        $pdf = Pdf::loadView('pdflaporankategori', [
            'laporan_kategori' => $laporan
        ]);

        return $pdf->download('laporan_kategori_barang.pdf');
    }

    public function cetakLaporanPenitipan()
    {
        $laporan = DB::table('barang as b')
            ->select(
                'b.id_barang',
                'b.nama_barang',
                'b.id_penitip',
                'p.nama_penitip as nama_penitip',
                'b.tanggal_penitipan',
                'b.tanggal_keluar',
            )
            ->leftJoin('penitip as p', 'b.id_penitip', '=', 'p.id_penitip')
            ->where('b.status_penitipan', 'habis')
            ->get();

        $tanggalCetak = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('pdflaporanpenitip', [
            'laporan_penitipan' => $laporan,
            'tanggal_cetak' => $tanggalCetak
        ]);

        return $pdf->download('laporan_penitipan_barang.pdf');
    }


}