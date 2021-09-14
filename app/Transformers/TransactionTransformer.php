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

            /* HATEOAS IMPLEMENTATION */
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('transactions.show', $transaction->id)
                ],
                [
                    'rel' => 'buyer',
                    'href' => route('buyers.show', $transaction->buyer_id)
                ],
                [
                    'rel' => 'transactions.sellers',
                    'href' => route('transactions.sellers.index', $transaction->id)
                ],
                [
                    'rel' => 'transactions.categories',
                    'href' => route('transactions.categories.index', $transaction->id)
                ],
                [
                    'rel' => 'product',
                    'href' => route('products.show', $transaction->product_id)
                ],
            ],
        ];
    }

    public static function getOriginalAttribute(string $transformedAttribute)
    {
        $attribute = [
            'identifier' => 'id',
            'quantity' => 'quantity',
            'buyer' => 'buyer_id',
            'product' => 'product_id',
            'creationDate' => 'created_at',
            'lastChangeDate' => 'updated_at',
            'deletionDate' => 'deleted_at',
        ];

        return $attribute[$transformedAttribute] ?? null;
    }
}
