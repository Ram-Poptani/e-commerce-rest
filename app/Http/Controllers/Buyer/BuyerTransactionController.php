<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer;
use App\Http\Controllers\ApiController;

class BuyerTransactionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->only(
                'index'
            );
        $this->middleware('scope:read-general')
            ->only(
                'index'
            );
        $this->middleware('can:view,buyer')
            ->only(
                'index'
            );
    }

    public function index(Buyer $buyer)
    {
        $transactions = $buyer->transactions;
        return $this->showAll($transactions);
    }
}
