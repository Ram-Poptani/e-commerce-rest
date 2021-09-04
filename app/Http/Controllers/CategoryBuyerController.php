<?php


namespace App\Http\Controllers;


use App\Models\Category;

class CategoryBuyerController extends ApiController
{

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
