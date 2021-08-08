<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerCategoryController extends Controller
{

    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()
            ->with('product.categories')
            ->get()
            ->pluck('product.categories')
            ->collapse()
            ->unique('id')
            ->values();

        return $this->showAll($categories);
    }

}
