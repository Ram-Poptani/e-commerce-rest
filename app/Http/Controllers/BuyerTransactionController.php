<?php

namespace App\Http\Controllers;

use App\Models\Buyer;

class BuyerTransactionController extends Controller
{
    public function index(Buyer $buyer)
    {
        $transactions = $buyer->transactions;
        return $this->showAll($transactions);
    }
}
