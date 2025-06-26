<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penitip;
use App\Models\Barang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PenitipController extends Controller
{

    public function home()
    {
        $penitip = Auth::guard('penitip')->user();

        if (!$penitip) {
            return redirect()->route('login')->withErrors(['login_error' => 'Silakan login terlebih dahulu!']);
        }

        // Optimasi: Gunakan variabel $penitip tanpa panggil ulang Auth
        $barangTitipan = Barang::with('kategori')->where('id_penitip', $penitip->id_penitip)->get();

        return view('homePenitip', compact('penitip', 'barangTitipan'));
    }



    // Logout penitip
    public function logout(Request $request)
    {
        $penitip = Auth::guard('penitip')->user();
        if ($penitip) {
            $penitip->tokens()->delete();
            return response()->json(['message' => 'Logout berhasil']);
        }

        return response()->json(['message' => 'Anda belum login'], 401);
    }


    // Menampilkan semua penitip
    public function index()
    {
        $penitip = Penitip::all()->makeHidden(['password_penitip']);
        return response()->json($penitip);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penitip' => 'required|string|max:255',
            'no_telp_penitip' => 'required|string|max:15',
            'email_penitip' => 'required|email|unique:penitip,email_penitip',
            'password_penitip' => 'required|string|min:6',
            'nik_penitip' => 'required|string|max:16|unique:penitip,nik_penitip',
            'gambar_penitip' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'poin_penitip' => 'nullable|integer',
            'saldo_penitip' => 'nullable|numeric',
            'badge_penitip' => 'nullable|string',
            'rating_penitip' => 'nullable|integer',
            'total_barang_terjual' => 'nullable|integer',
        ]);

        // Proses upload gambar ke public/images
        $gambarPath = null;
        if ($request->hasFile('gambar_penitip')) {
            $file = $request->file('gambar_penitip');
            $filename = $file->getClientOriginalName(); // Nama unik
            $file->move(public_path('images'), $filename);
            $gambarPath = 'images/' . $filename;
        }

        $penitip = Penitip::create([
            'nama_penitip' => $request->nama_penitip,
            'no_telp_penitip' => $request->no_telp_penitip,
            'email_penitip' => $request->email_penitip,
            'password_penitip' => Hash::make($request->password_penitip),
            'nik_penitip' => $request->nik_penitip,
            'poin_penitip' => $request->poin_penitip ?? 0,
            'saldo_penitip' => $request->saldo_penitip ?? 0,
            'badge_penitip' => $request->badge_penitip ?? 'Top',
            'rating_penitip' => $request->rating_penitip ?? 0,
            'total_barang_terjual' => $request->total_barang_terjual ?? 0,
            'gambar_penitip' => $gambarPath,
        ]);

        return redirect()->route('pegawai.dashboard', ['halaman' => 'daftar-penitip'])
            ->with('success', 'Data penitip berhasil diperbarui');
    }

    // Mencari penitip berdasarkan ID
    public function search($id)
    {
        $penitip = Penitip::find($id);

        if (!$penitip) {
            return response()->json(['message' => 'Penitip tidak ditemukan'], 404);
        }

        return response()->json($penitip->makeHidden(['password_penitip']));
    }

    // Mengupdate penitip
    public function update(Request $request, $id)
    {
        $penitip = Penitip::find($id);

        if (!$penitip) {
            return redirect()->back()->with('error', 'Penitip tidak ditemukan');
        }

        $request->validate([
            'nama_penitip' => 'sometimes|string|max:255',
            'email_penitip' => 'sometimes|email|max:255|unique:penitip,email_penitip,' . $id . ',id_penitip',
            'no_telp_penitip' => 'sometimes|string|max:20',
            'nik_penitip' => 'sometimes|string|max:20',
            'poin_penitip' => 'sometimes|integer|min:0',
            'saldo_penitip' => 'sometimes|numeric|min:0',
            'badge_penitip' => 'sometimes|string|max:50',
            'rating_penitip' => 'sometimes|numeric|min:0|max:5',
            'gambar_penitip' => 'nullable|image|max:2048',
            
        ]);

        $data = $request->all();

        if ($request->filled('password_penitip')) {
            $data['password_penitip'] = Hash::make($request->password_penitip);
        } else {
            unset($data['password_penitip']);
        }

        if ($request->hasFile('gambar_penitip')) {
            $file = $request->file('gambar_penitip');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('images'), $filename); // Simpan ke public/images

            $data['gambar_penitip'] = 'images/' . $filename; // Simpan path-nya ke DB
        }


        $penitip->update($data);

        return redirect()->route('pegawai.dashboard', ['halaman' => 'daftar-penitip'])
            ->with('success', 'Data penitip berhasil diperbarui');
    }


    // Menghapus penitip
    public function destroy($id)
    {
        $penitip = Penitip::find($id);

        if (!$penitip) {
            return response()->json(['message' => 'Penitip tidak ditemukan'], 404);
        }

        $penitip->delete();

        return redirect()->route('pegawai.dashboard', ['halaman' => 'daftar-penitip'])
            ->with('success', 'Data penitip berhasil diperbarui');
    }

}