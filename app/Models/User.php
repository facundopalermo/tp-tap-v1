<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /*
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /* Mutadores y Accesores */
    protected function name(): Attribute {
        return new Attribute(
            get: fn($value) => ucwords($value),

            set: function($value){
                return strtolower($value);
            }
        );
    }

    public function password(): Attribute {
        return new Attribute(set: fn ($value) => Hash::make($value));
    }
}