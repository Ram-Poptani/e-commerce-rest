<?php


namespace App\Http\Controllers\Product;


use App\Http\Controllers\ApiController;
use App\Models\Product;

class ProductBuyerController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth.api')
            ->only(
                'index'
            );
    }

    public function index(Product $product)
    {
        $buyers = $product->transactions()
                    ->with('buyer')
                    ->get()
                    ->pluck('buyer')
                    ->unique('id');
        return $this->showAll($buyers);
    }

}
