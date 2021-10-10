<?php


namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;

class CategoryBuyerController extends ApiController
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
        $buyers = $category->products()
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->flatten()
            ->pluck('buyer')
            ->unique()
            ->values();

        return $this->showAll($buyers);
    }
}
