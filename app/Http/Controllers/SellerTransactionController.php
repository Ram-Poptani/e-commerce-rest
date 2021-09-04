<?php


namespace App\Http\Controllers;


use App\Models\Seller;

class SellerTransactionController extends ApiController
{

    public function index(Seller $seller)
    {
        $transactions = $seller->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->flatten();

        return $this->showAll($transactions);
    }
}