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

    protected $fillable = [
        //user name
        'name',
        //user email
        'email',
        //user email`s password
        'password',
        //user account_id
        'account_id',
        //user account_type
        'account_type',
        //user account balance
        'balance'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    protected $table = 'users';

    //relation between user and transaction that user can create many transactions
    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }
}
