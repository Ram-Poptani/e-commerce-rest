<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use App\Http\Controllers\ApiController;

class SellersController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth.api')
            ->only(
                'index'
            );
    }

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
