<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use App\Models\Penitip;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class PembeliController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:pembeli,email_pembeli',
            'no_telp' => 'required|string',
        ]);

        $user = Pembeli::create([
            'nama_pembeli' => $request->nama,
            'password_pembeli' => Hash::make($request->password),
            'email_pembeli' => $request->email,
            'no_telp_pembeli' => $request->no_telp,
            'poin_pembeli' => 0, // Tanpa menyimpan id_role di DB
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }



    public function home()
    {
        $barang = Barang::all(); // Ambil semua barang dari database
        return view('homePembeli', compact('barang')); // Kirim data ke tampilan Blade
    }


    public function logout(Request $request) {
        if (auth()->guard('pembeli')->check()) { // Logout khusus pembeli
            auth()->guard('pembeli')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }

        return redirect()->route('login')->with('error', 'Tidak ada pengguna yang sedang login');
    }


  
    public function update(Request $request, $id_pembeli){
        $pembeli = Pembeli::findOrFail($id_pembeli);
                
        $request->validate([
            'nama_pembeli' => 'sometimes|string',
            'password_pembeli' => 'sometimes|min:6',
            'email_pembeli' => "sometimes|email|unique:pembeli,email_pembeli,{$id_pembeli},id_pembeli", // Perbaikan disini
            'no_telp_pembeli' => 'sometimes|string'
        ]);
        
        // Persiapkan data update
        $updateData = $request->only(['nama_pembeli', 'email_pembeli', 'no_telp_pembeli']);
        
        // Jika password diupdate, hash dulu
        if ($request->has('password_pembeli')) {
            $updateData['password_pembeli'] = Hash::make($request->password_pembeli);
        }
        
        $pembeli->update($updateData);
        
        return response()->json(['message' => 'Data berhasil diperbarui', 'pembeli' => $pembeli]);
    }

    public function showProfile()
    {

        $pembeli = Auth::user(); // Ambil data dari pengguna yang login

        if (!$pembeli) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        return view('profilePembeli', compact('pembeli')); // Kirim data ke tampilan Blade
    }

    private function getRedirectRouteById($id_role)
    {
        $routes = [
            10 => 'homePembeli',
            20 => 'homePenitip',
        ];
        return $routes[$id_role] ?? 'login';
    }

    public function simpanFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $pembeli = auth('sanctum')->user(); // Gunakan token login dari Flutter

        if ($pembeli) {
            $pembeli->fcm_token = $request->fcm_token;
            $pembeli->save();

            return response()->json(['message' => 'Token FCM disimpan']);
        }

        return response()->json(['message' => 'Pengguna tidak ditemukan'], 401);
    }

}