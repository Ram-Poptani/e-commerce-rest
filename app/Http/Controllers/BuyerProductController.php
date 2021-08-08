<?php

namespace App\Http\Controllers;

use App\Models\Buyer;

class BuyerProductController extends Controller
{
    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions()
            ->with('product')
            ->get()
            ->pluck('product');

        return $this->showAll($products);
    }
}
