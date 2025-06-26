<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestDonasi;

class RequestDonasiController extends Controller
{
    public function index()
    {
        $organisasi = auth()->guard('organisasi')->user();
        
        $requests = RequestDonasi::where('id_organisasi', $organisasi->id_organisasi)->get();

        return view('organisasiView', compact('organisasi', 'requests'));
    }


    // Simpan data request donasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'deskripsi_request' => 'required|string',
            'tanggal_request' => 'required|date',
            'id_organisasi' => 'required|exists:organisasi,id_organisasi',
        ]);

        $validated['id_pegawai'] = 3;

        $validated['status_request'] = 'Diproses';

        $donasi = RequestDonasi::create($validated);
        
        return redirect()->route('organisasiView')->with('success', 'Request berhasil ditambahkan!');
    }

    // Tampilkan detail satu data berdasarkan id
    public function show($id)
    {
        $donasi = RequestDonasi::with(['pegawai', 'organisasi'])->find($id);

        if (!$donasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($donasi);
    }

    // Update data request donasi
    public function update(Request $request, $id)
    {
        $donasi = RequestDonasi::find($id);

        if (!$donasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Validasi hanya dua field yang boleh diubah
        $validated = $request->validate([
            'deskripsi_request' => 'required|string',
            'tanggal_request' => 'required|date',
        ]);

        $donasi->update([
            'deskripsi_request' => $validated['deskripsi_request'],
            'tanggal_request' => $validated['tanggal_request'],
        ]);

        return redirect()->route('organisasiView')->with('success', 'Request berhasil diperbarui!');
    }


    // Hapus data request donasi
    public function destroy($id)
    {
        $donasi = RequestDonasi::find($id);

        if (!$donasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $donasi->delete();

        return redirect()->route('organisasiView')->with('success', 'Request berhasil diperbarui!');
    }
}
