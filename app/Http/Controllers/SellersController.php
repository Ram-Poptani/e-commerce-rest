<?php

namespace App\Http\Controllers;

use App\Models\Seller;

class SellersController extends ApiController
{
    public function index()
    {
        $sellers = Seller::has('products')->get();
        return $this->showAll($sellers);
    }

    public function show(Seller $seller)
    {
        return $this->showOne($seller);
    }
}
