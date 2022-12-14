<?php

namespace App\Policies;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function view(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    public function updateProduct(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    public function destroyProduct(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    public function sell(User $user, User $seller)
    {
        return $user->id === $seller->id;
    }
}
