<?php

namespace App\Models;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Transformers\UserTransformer;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    public $transformer = UserTransformer::class;

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

    protected static function boot()
    {
        parent::boot();

        self::created(function (User $user) {
            Mail::to($user)->send(new UserCreated($user));
        });

        self::updated(function (User $user) {
            if ($user->isDirty('email'))
            {
                retry(5, function () use($user) {
                    Mail::to($user)->send(new UserMailChanged($user));
                }, 500);
            }
        });
    }

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
