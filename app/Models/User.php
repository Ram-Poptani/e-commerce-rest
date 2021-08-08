<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;

    const ADMIN_USER = 1;
    const REGULAR_USER = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    public function isVerified()
    {
        return $this->verified == self::VERIFIED_USER;
    }

    public function isAdmin()
    {
        return $this->admin == self::ADMIN_USER;
    }

    public static function generateVerificationTokenCode()
    {
        return Str::random(40);
    }

    public function getNameAttribute()
    {
        return ucwords($this->attributes['name']);
    }

    /* MUTATORS */

    public function setNameAttribute(String $name)
    {
        $this->attributes['name'] = $name;
    }

    public function setEmailAttribute(String $email)
    {
        $this->attributes['email'] = $email;
    }

}
