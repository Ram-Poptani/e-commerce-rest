<?php


namespace App\Http\Controllers;


use App\Models\Category;

class CategoryProductController extends ApiController
{

    public  function index(Category  $category)
    {
        $products = $category->products;
        return $this->showAll($products);
    }
}
