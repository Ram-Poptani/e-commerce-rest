<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellersController extends ApiController
{
    public function index()
    {
        $buyers = Seller::has('products')->get();
        return $this->showAll($buyers);
    }

    public function show($id)
    {
        $buyer = Seller::has('products')->findOrFail($id);
        return $this->showOne($buyer);
    }
}
