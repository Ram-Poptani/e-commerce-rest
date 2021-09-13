<?php

namespace App\Models;

use App\Scopes\SellerScope;
use App\Transformers\SellerTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends User
{
    use HasFactory;

    protected $table = "users";

    public $transformer = SellerTransformer::class;

    public function __construct()
    {
        array_push($this->hidden, 'admin');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScope());
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
