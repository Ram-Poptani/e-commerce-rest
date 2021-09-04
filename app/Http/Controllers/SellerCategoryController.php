<?php


namespace App\Http\Controllers;


use App\Models\Seller;

class SellerCategoryController extends ApiController
{

    public function index(Seller $seller)
    {
        $categories = $seller->products()
            ->whereHas('categories')
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->flatten()
            ->unique("id")
            ->values();

        return $this->showAll($categories);
    }
}
