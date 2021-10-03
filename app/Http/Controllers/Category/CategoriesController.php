<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoriesController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:'.CategoryTransformer::class)
            ->only(
                'store',
                'update'
            );
        $this->middleware('client.credentials')
            ->only(
                'index',
                'show'
            );
        $this->middleware('auth.api')
            ->only(
                'index'
            );
    }

    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:2',
            'description' => 'required|min:2',
        ];
        $this->validate($request, $rules);

        $data = $request->all();
        $category = Category::create($data);
        return $this->showOne($category, 201);
    }

    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->fill($request->only(['name', 'description']));

        if ($category->isClean()) {
            return $this->errorResponse("You need to change something to update", 422);
        }
        $category->save();
        return $this->showOne($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
