<?php

namespace Database\Factories;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $seller = Seller::has('products')->with('products')->get()->random();
        $buyer = Buyer::all()->except($seller->id)->random();
        return [
            'quantity' => $this->faker->numberBetween(1, 10),
            'buyer_id' => $buyer->id,
            'product_id' => Product::all()->random()->id
        ];
    }
}
