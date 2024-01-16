<?php

namespace Tests\Unit;

use App\Models\Orders;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_Index()
    {
        $users = [
            [
                'name' => 'ali',
                'email' => 'ali@eg.com',
                'password' => '1234',
                'account_id' => 1,
                'account_type' => 'customer',
                'balance' => '1650.00'
            ],
            [
                'name' => 'kareem',
                'email' => 'kareem@eg.com',
                'password' => '1234',
                'account_id' => 2,
                'account_type' => 'merchant',
                'balance' => '1750.00'
            ],
        ];
        $order = Orders::create();
        foreach ($users as $user) {
            $myuser = User::create($user);
        }
        DB::table('transactions_types')->insert([
            ['name' => 'MerchantFees'],
            ['name' => 'servicesFees'],
            ['name' => 'PaymentTaxes'],
            ['name' => 'DeliveryFees'],
        ]);
//        $Transactions = [
//            [
//                'user_id' => $users[1]['account_id'],
//                'order_id' => 1,
//                'type' => '',
//                'fromable_account_id' => $users[1]['account_id'],
//                'fromable_account_type' => "customer",
//                'fromable_account_balance' => 1500,
//                'toable_account_id' => $users[2]['account_id'],
//                'toable_account_type' => "merchant",
//                'toable_account_balance' => 2500,
//                'amount' => 250
//            ],
//            [
//                'user_id' => 1,
//                'order_id' => 1,
//                'type' => 1,
//                'fromable_account_id' => 1,
//                'fromable_account_type' => "customer",
//                'fromable_account_balance' => 1500,
//                'toable_account_id' => 2,
//                'toable_account_type' => "merchant",
//                'toable_account_balance' => 2500,
//                'amount' => 250
//            ],
//            [
//                'user_id' => 1,
//                'order_id' => 1,
//                'type' => 1,
//                'fromable_account_id' => 1,
//                'fromable_account_type' => "customer",
//                'fromable_account_balance' => 1500,
//                'toable_account_id' => 2,
//                'toable_account_type' => "merchant",
//                'toable_account_balance' => 2500,
//                'amount' => 250
//            ],
//        ];
        $Transactions = Transactions::create([
            'user_id' => $myuser->id,
            'order_id' => $order->id,
            'type' => 1,
            'fromable_account_id' => 1,
            'toable_account_id' => 2,
            'fromable_account_type' => 'merchant',
            'toable_account_type' => 'merchant',
            'fromable_account_balance' => 3000,
            'toable_account_balance' => 2500,
            'amount' => 250
        ]);
        $response = $this->get('http://localhost:8000/api/transactions');

        $response->assertStatus(201);
        $response->assertJson(array(
                'success' => true,
                'transactions' => array(
                    0 => array(
                        'id' => 1,
                        'user_id' => 2,
                        'order_id' => 1,
                        'type' => 1,
                        'fromable_account_id' => 1,
                        'fromable_account_type' => 'merchant',
                        'fromable_account_balance' => '3000.00',
                        'toable_account_id' => 2,
                        'toable_account_type' => 'merchant',
                        'toable_account_balance' => '2500.00',
                        'amount' => '250.00',
                    )
                )
            )
        );
    }

}
