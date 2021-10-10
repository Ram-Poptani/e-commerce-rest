<?php

namespace App\Http\Controllers\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionsController extends ApiController
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
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }

    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }
}
