<?php


namespace App\Http\Controllers\Product;


use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{

    public function __construct()
    {
        $this->middleware('transform.input:'.CategoryTransformer::class)
            ->only(
                'update'
            );

        $this->middleware('client.credentials')
            ->only(
                'index'
            );
    }

    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    public function update(Request $request, Product $product, Category $category)
    {
        $product->categories()->syncWithoutDetaching($category->id);
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    public function destroy(Product $product, Category $category)
    {
        if (! $product->categories()->find($category->id))
        {
            return $this->errorResponse('The Product does not belong to the specified category', 404);
        }
        $product->categories()->detach($category->id);
        $categories = $product->categories;
        return $this->showAll($categories);
    }

}
