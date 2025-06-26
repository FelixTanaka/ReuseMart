<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use Illuminate\Support\Facades\Auth;

class MerchandiseController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user(); 

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $merchandise = Merchandise::where('stok_merch', '>', 0)->get();

        return response()->json([
            'message' => 'Daftar merchandise tersedia',
            'data' => $merchandise
        ]);
    }
}
