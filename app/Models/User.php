<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
 protected $fillable = [
    'name',
    'email',
    'password',
    'first_name',
    'last_name',
    'birth_date',
    'country',
    'state',
    'city',
    'profile_image',
    'residential_proofs',
    'education',
    'occupation',
    'age',
    'is_profile_completed', // <-- Add this
];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
protected $casts = [
    'profile_completed' => 'boolean',
    'residential_proofs' => 'array',
    'email_verified_at' => 'datetime',
        'password' => 'hashed',
];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
  
}
