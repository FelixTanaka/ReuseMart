<?php

namespace App\Http\Controllers;

use App\Models\TransaksiMerchandise;
use App\Models\Merchandise;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiMerchandiseController extends Controller
{
    public function tukar(Request $request)
    {
        $request->validate([
            'id_merch' => 'required|exists:merchandise,id_merch',
        ]);

        $idPembeli = Auth::id(); // Ambil ID user dari token

        // Ambil pembeli
        $pembeli = Pembeli::where('id_pembeli', $idPembeli)->first();

        if (!$pembeli) {
            return response()->json(['message' => 'Pembeli tidak ditemukan'], 404);
        }

        $merch = Merchandise::find($request->id_merch);

        if ($merch->stok_merch <= 0) {
            return response()->json(['message' => 'Stok tidak mencukupi'], 400);
        }

        if ($pembeli->poin_pembeli < $merch->poin_merch) {
            return response()->json(['message' => 'Poin tidak mencukupi'], 400);
        }

        // Buat transaksi
        $transaksi = TransaksiMerchandise::create([
            'id_pembeli' => $pembeli->id_pembeli,
            'id_merch' => $merch->id_merch,
            'tanggal_reedem' => now(),
            'tanggal_pengambilan' => null,
        ]);

        // Kurangi stok merchandise
        $merch->decrement('stok_merch');

        // Kurangi poin pembeli
        $pembeli->poin_pembeli -= $merch->poin_merch;
        $pembeli->save();

        return response()->json([
            'message' => 'Berhasil menukar merchandise',
            'transaksi' => $transaksi,
            'sisa_poin' => $pembeli->poin_pembeli,
        ]);
    }
}
