<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'identifier' => (int)$user->id,
            'name' => $user->name,
            'email' => $user->email,
            'isVerified' => (bool)$user->isVerified(),
            'isAdmin' => (bool)$user->isAdmin(),
            'creationDate' => $user->created_at,
            'lastChangeDate' => $user->updated_at,
            'deletionDate' => $user->deleted_at ?? null,
        ];
    }

    public static function getOriginalAttribute(string $transformedAttribute)
    {
        $attribute = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'isAdmin' => 'admin',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation',
            'creationDate' => 'created_at',
            'lastChangeDate' => 'updated_at',
            'deletionDate' => 'deleted_at',
        ];

        return $attribute[$transformedAttribute] ?? null;
    }

    public static function getTransformedAttribute(string $originalAttribute)
    {
        $attribute = [
            'id' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'verified' => 'isVerified',
            'admin' => 'isAdmin',
            'password' => 'password',
            'password_confirmation' => 'password_confirmation',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChangeDate',
            'deleted_at' => 'deletionDate',
        ];

        return $attribute[$originalAttribute] ?? null;
    }
}
