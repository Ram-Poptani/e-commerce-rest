<?php


namespace App\Http\Controllers\Product;


use App\Http\Controllers\ApiController;
use App\Models\Product;

class ProductTransactionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->only(
                'index'
            );
    }

    public function index(Product $product)
    {
        $transactions = $product->transactions;
        return $this->showAll($transactions);
    }

}
