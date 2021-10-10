<?php

namespace App\Policies;

use App\Models\Buyer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuyerPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Buyer $buyer)
    {
        return $user->id === $buyer->id;
    }
    public function purchase(User $user, Buyer $buyer)
    {
        return $user->id === $buyer->id;
    }

}