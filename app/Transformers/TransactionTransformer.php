<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int)$transaction->id,
            'quantity' => $transaction->quantity,
            'buyer' => $transaction->buyer_id,
            'product' => (bool)$transaction->product_id,
            'creationDate' => $transaction->created_at,
            'lastChangeDate' => $transaction->updated_at,
            'deletionDate' => $transaction->deleted_at ?? null,
        ];
    }
}
