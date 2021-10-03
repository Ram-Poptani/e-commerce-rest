<?php


namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;

class CategoryProductController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')
            ->only(
                'index',
                'show'
            );
    }

    public  function index(Category  $category)
    {
        $products = $category->products;
        return $this->showAll($products);
    }
}
