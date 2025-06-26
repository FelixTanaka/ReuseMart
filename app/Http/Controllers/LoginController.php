<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembeli;
use App\Models\Penitip;
use App\Models\Pegawai;
use App\Models\Role;
use App\Models\Organisasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    public function loginWeb(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cek user di empat tabel
        $user = Pembeli::where('email_pembeli', $request->email)->first()
            ?? Penitip::where('email_penitip', $request->email)->first()
            ?? Pegawai::where('email_pegawai', $request->email)->first()
            ?? Organisasi::where('email_organisasi', $request->email)->first();

        // Jika email tidak ditemukan
        if (!$user) {
            return back()->withErrors(['login_error' => 'Email tidak ditemukan'])->withInput();
        }

        // Ambil kolom password yang sesuai
        $passwordField = $user instanceof Pembeli ? 'password_pembeli' :
                        ($user instanceof Penitip ? 'password_penitip' :
                        ($user instanceof Pegawai ? 'password_pegawai' : 'password_organisasi'));

        // Cek password
        if (!Hash::check($request->password, $user->$passwordField)) {
            return back()->withErrors(['login_error' => 'Password salah'])->withInput();
        }

        // Tentukan guard
        $guard = $user instanceof Pembeli ? 'pembeli' :
                ($user instanceof Penitip ? 'penitip' :
                ($user instanceof Pegawai ? 'pegawai' : 'organisasi'));

        // Login dan buat token
        Auth::guard($guard)->login($user);
        $request->session()->regenerate();
        $token = $user->createToken('api-token')->plainTextToken;

        // Redirect berdasarkan guard
        if ($guard === 'pembeli') {
            return redirect()->route('homePembeli');
        } elseif ($guard === 'penitip') {
            return redirect()->route('homePenitip');
        } elseif ($guard === 'pegawai') {
            return redirect()->route('pegawai.dashboard');
        } elseif ($guard === 'organisasi') {
            return redirect()->route('organisasiView');
        }
    }


    public function loginApi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = Pembeli::where('email_pembeli', $request->email)->first()
            ?? Penitip::where('email_penitip', $request->email)->first()
            ?? Pegawai::where('email_pegawai', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        $passwordField = $user instanceof Pembeli ? 'password_pembeli' :
                         ($user instanceof Penitip ? 'password_penitip' : 'password_pegawai');

        if (!Hash::check($request->password, $user->$passwordField)) {
            return response()->json(['message' => 'Password salah'], 401);
        }

        $guard = $user instanceof Pembeli ? 'pembeli' :
                 ($user instanceof Penitip ? 'penitip' : 'pegawai');

        $token = $user->createToken('auth_token')->plainTextToken;

            
        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id_pegawai' => $user->id_pegawai,
                'email' => $request->email,
                'role' => $user instanceof Pegawai 
                    ? ['id_role' => $user->id_role] 
                    : ['nama_role' => $guard], // pembeli atau penitip
            ],
        ]);
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('message', 'Logout berhasil!');
    }

    public function register(Request $request)
    {
        if ($request->nama_role === 'pembeli') {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|unique:pembeli,email_pembeli',
                'password' => 'required|min:6',
                'no_telp' => 'required|string|max:15',
            ]);
            $user = Pembeli::create([
                'nama_pembeli' => $request->nama,
                'password_pembeli' => Hash::make($request->password),
                'email_pembeli' => $request->email,
                'no_telp_pembeli' => $request->no_telp,
                'poin_pembeli' => 0,
            ]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil sebagai pembeli! Silakan login.');
        } elseif($request->nama_role === 'organisasi'){
            

            $request->validate([
                'nama' => 'required|string|max:255',
                'alamat_organisasi' => 'required|string|max:255',
                'no_telp' => 'required|string|max:15',
                'email' => 'required|email|unique:organisasi,email_organisasi',
                'password' => 'required|string|min:6',
                'foto_organisasi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $fotoPath = $request->hasFile('foto_organisasi')
                ? $request->file('foto_organisasi')->store('uploads/organisasi', 'public')
                : 'uploads/organisasi/default.jpg';
 
            $organisasi = Organisasi::create([
                'nama_organisasi' => $request->nama,
                'alamat_organisasi' => $request->alamat_organisasi,
                'no_telp_organisasi' => $request->no_telp,
                'email_organisasi' => $request->email,
                'foto_organisasi' => $fotoPath,
                'password_organisasi' => bcrypt($request->password),
            ]);
            return redirect()->route('login')->with('success', 'Registrasi berhasil sebagai organisasi! Silakan login.');
        }
    }

}


