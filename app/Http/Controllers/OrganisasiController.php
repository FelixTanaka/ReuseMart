<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OrganisasiController extends Controller
{
    public function index()
    {
        $organisasi = Organisasi::all();
        return response()->json($organisasi);
    }

    public function search($id)
    {
        $organisasi = Organisasi::find($id);
        if (!$organisasi) {
            return response()->json(['message' => 'Organisasi tidak ditemukan'], 404);
        }
        return response()->json($organisasi);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_organisasi' => 'required|email',
            'password_organisasi' => 'required|string',
        ]);

        $organisasi = Organisasi::where('email_organisasi', $request->email_organisasi)->first();

        if (!$organisasi) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // Cek jika password tidak menggunakan format bcrypt (kemungkinan plaintext)
        if (strlen($organisasi->password_organisasi) < 60) {
            // Jika password di database sama persis dengan input (plaintext)
            if ($request->password_organisasi === $organisasi->password_organisasi) {
                // Berhasil login
                $token = $organisasi->createToken('authToken')->plainTextToken;

                return response()->json([
                    'message' => 'Login berhasil',
                    'data' => $organisasi->makeHidden(['password_organisasi']),
                    'token' => $token
                ]);
            }
        } else {
            // Coba verifikasi dengan bcrypt
            try {
                if (Hash::check($request->password_organisasi, $organisasi->password_organisasi)) {
                    $token = $organisasi->createToken('authToken')->plainTextToken;

                    return response()->json([
                        'message' => 'Login berhasil',
                        'data' => $organisasi->makeHidden(['password_organisasi']),
                        'token' => $token
                    ]);
                }
            } catch (\Exception $e) {
                // Tangani kemungkinan error hash check
            }
        }

        // Jika semua pengecekan gagal
        return response()->json(['message' => 'Email atau password salah'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    public function update(Request $request, $id)
    {
        $organisasi = Organisasi::find($id);

        if (!$organisasi) {
            return response()->json(['message' => 'Organisasi tidak ditemukan'], 404);
        }

        // Validasi input
        $request->validate([
            'nama_organisasi' => 'sometimes|string|max:255',
            'alamat_organisasi' => 'sometimes|string|max:255',
            'no_telp_organisasi' => 'sometimes|string|max:15',
            'email_organisasi' => 'sometimes|email|unique:organisasi,email_organisasi,'.$id.',id_organisasi',
            'foto_organisasi' => 'sometimes|string',
        ]);

        // Jika ada password baru, hash terlebih dahulu
        if ($request->has('password_organisasi')) {
            $request->merge([
                'password_organisasi' => bcrypt($request->password_organisasi)
            ]);
        }

        $organisasi->update($request->all());

        return response()->json(['message' => 'Organisasi berhasil diperbarui', 'data' => $organisasi->makeHidden(['password_organisasi'])]);
    }

    public function destroy($id)
    {
        $organisasi = Organisasi::find($id);

        if (!$organisasi) {
            return response()->json(['message' => 'Organisasi tidak ditemukan'], 404);
        }

        $organisasi->delete();

        return response()->json(['message' => 'Organisasi berhasil dihapus']);
    }
}