<?php

namespace laravel\LaravelTransactionPackage\Models;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transactions extends Model
{
    use HasFactory;

    //Here are the fillabel attributes that required when you want to create a new transaction
    protected $fillable = [
        //the id of user who will create this transaction
        'user_id',
        //the order_id that this transaction will belong to
        'order_id',
        //the type of the transaction
        'type',
        //the account will send the transaction
        'fromable_account_type',
        //the account will receive this transaction
        'toable_account_type',
        //the account_id of transaction`s sender
        'fromable_account_id',
        //the account_id of transaction`s receiver
        'toable_account_id',
        //the account_balance of transaction`s sender
        'fromable_account_balance',
        //the account_balance of transaction`s receiver
        'toable_account_balance',
        //the amount of this transaction
        'amount',
    ];
    protected $table = 'transactions';

    //relation between user and transaction that every transaction belong to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relation between order and transaction that every transaction should belong to an order
    public function orders()
    {
        return $this->belongsTo(Orders::class);
    }

    //polymorphic relation between transaction`s table and user`s table that relate transaction`s sender to fromable_account_type and fromable_account_id
    public function fromable()
    {
        return $this->morphTo('fromable_account', 'fromable_account_type', 'fromable_account_id');
    }

    //polymorphic relation between transaction`s table and user`s table that relate transaction`s receiver to toable_account_type and toable_account_id
    public function toable()
    {
        return $this->morphTo('toable_account', 'toable_account_type', 'toable_account_id');
    }

    //updateBalance function is responsible for updating users` balances in users` table and also in transactions` table after transaction created
//    public function updateBalances()
//    {
//        DB::transaction(function () {
//            $this->load('fromable', 'toable');
//            // Check if the related users exist
//            if ($this->fromable_account && $this->toable_account) {
//                // Update balances in users table
//                $this->fromable_account->balance -= $this->amount;
//                $this->toable_account->balance += $this->amount;
//
//                // Save changes to the database
//                $this->fromable_account->save();
//                $this->toable_account->save();
//
//                // Update balances in the transaction table
//                $this->update([
//                    'fromable_account_balance' => $this->fromable_account->balance,
//                    'toable_account_balance' => $this->toable_account->balance,
//                ]);
//            }
//        });
//    }
}
