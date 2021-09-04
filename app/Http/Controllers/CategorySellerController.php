<?php


namespace App\Http\Controllers;


use App\Models\Category;

class CategorySellerController extends ApiController
{

    public function index(Category $category)
    {
        $sellers = $category->products()
            ->with('seller')
            ->get()
            ->pluck('seller')
            ->unique()
            ->values();

        return $this->showAll($sellers);
    }
}
