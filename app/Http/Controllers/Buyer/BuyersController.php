<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer;
use App\Http\Controllers\ApiController;

class BuyersController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:api')
            ->only(
                'index'
            );
    }

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
