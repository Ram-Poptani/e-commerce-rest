<?php


namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use App\Transformers\ProductTransformer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{

    public function __construct()
    {
        $this->middleware('transform.input:'.ProductTransformer::class)
            ->only(
                'store',
                'update'
            );
        $this->middleware('auth:api')
            ->only(
                'index'
            );
        $this->middleware('scope:manage-product')->except('index');
    }

    public function index(Seller $seller)
    {
        if (\request()->user()->tokenCan('read-general') || \request()->user()->tokenCan('manage-product')) {
            $products = $seller->products;
            return $this->showAll($products);
        }
        throw new AuthorizationException("Invalid Scopes");
    }

    public function store(Request $request, User $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image'
        ];

        $this->validate($request, $rules);
        $data = $request->all();

        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);
        return $this->showOne($product);
    }

    public function update(Request $request, Seller $seller, Product $product)
    {
        $this->verifySeller($seller, $product);

        $rules = [
            'name' => 'min:1',
            'description' => 'min:5',
            'quantity' => 'integer|min:1',
            'status' => 'in:' . Product::UNAVAILABLE_PRODUCT . ',' . Product::AVAILABLE_PRODUCT,
            'image' => 'image'
        ];

        $this->validate($request, $rules);

        $product->fill(
            $request->only([
                'name',
                'description',
                'quantity'
            ])
        );

        if ($request->has('statuus')) {
            $product->status = $request->status;

            if ($product->isAvailable() && $product->categories()->count() == 0) {
                return $this->errorResponse("A product must be associated with atleast one category to be Availabale!", 409);
            }
        }

        if ($request->hasFile('image')) {
            Storage::delete($product->image);
            $product->image = $request->image->store('');
        }

        if ($product->isClean()) {
            return $this->errorResponse("You have not updated any value!!", 422);
        }

        $product->save();
        return $this->showOne($product);
    }

    public function destroy(Seller $seller, Product $product)
    {
        $this->verifySeller($seller, $product);
        Storage::delete($product->image);
        $product->delete();
        return $this->showOne($product);
    }

    private function verifySeller(Seller $seller, Product $product)
    {
        if ($seller->id != $product->seller_id)
        {
            throw new HttpException(422, "You are trying to update someone else's product!");
        }
    }
}
