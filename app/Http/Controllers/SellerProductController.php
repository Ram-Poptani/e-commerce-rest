<?php


namespace App\Http\Controllers;


use App\Models\Seller;

class SellerProductController extends ApiController
{

    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }
}
