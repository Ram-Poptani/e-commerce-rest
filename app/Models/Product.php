<?php

namespace App\Models;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $transformer = ProductTransformer::class;

    const AVAILABLE_PRODUCT = 1;
    const UNAVAILABLE_PRODUCT = 2;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];

    protected $hidden = [
        'pivot'
    ];

    protected static function boot()
    {
        parent::boot();
        parent::updated(function (Product $product) {
            if ($product->quantity == 0 && $product->isAvailable())
            {
                $product->status = self::UNAVAILABLE_PRODUCT;
                $product->save();
            }
        });
    }

    public function isAvailable()
    {
        return $this->status == Product::AVAILABLE_PRODUCT;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
