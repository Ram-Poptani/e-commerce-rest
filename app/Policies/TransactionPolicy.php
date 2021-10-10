<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Transaction $transaction)
    {
        return $this->isBuyer($user, $transaction) || $this->isSeller($user, $transaction);
    }

    public function isBuyer(User $user, Transaction $transaction)
    {
        return $user->id === $transaction->buyer_id;
    }

    public function isSeller(User $user, Transaction $transaction)
    {
        return $user->id === $transaction->product->seller->id;
    }
}
