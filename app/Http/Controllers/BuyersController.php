<?php

namespace App\Http\Controllers;

use App\Models\Buyer;

class BuyersController extends ApiController
{
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();
        return $this->showAll($buyers);
    }

    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer, 200);
    }
}
