<?php


namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;

class CategoryTransactionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->only(
                'index'
            );
    }

    public function index(Category $category)
    {
        $transactions = $category->products()
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->flatten();

        return $this->showAll($transactions);
    }

}
