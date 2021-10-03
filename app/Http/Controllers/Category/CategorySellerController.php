<?php


namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;

class CategorySellerController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth.api')
            ->only(
                'index'
            );
    }

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
