<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellersController extends Controller
{
    public function index()
    {
        $buyers = Seller::has('products')->get();
        return response()->json([
            'count' => $buyers->count(),
            'data' => $buyers,
            'code' => 200
        ], 200);
    }

    public function show($id)
    {
        $buyer = Seller::has('products')->findOrFail($id);
        return response()->json([
            'data' => $buyer,
            'code' => 200
        ], 200);
    }
}
