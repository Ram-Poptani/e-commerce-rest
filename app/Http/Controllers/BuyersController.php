<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyersController extends Controller
{
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();
        return response()->json([
            'count' => $buyers->count(),
            'data' => $buyers,
            'code' => 200
            ], 200);
    }

    public function show($id)
    {
        $buyer = Buyer::has('transactions')->findOrFail($id);
        return response()->json([
            'data' => $buyer,
            'code' => 200
        ], 200);
    }
}
