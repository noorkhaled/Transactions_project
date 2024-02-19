<?php

namespace tests\Unit;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\LaravelTransactionPackage\Models\Transactions;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_Index()
    {
        $order = Orders::create();
        DB::table('transactions_types')->insert([
            ['name' => 'MerchantFees'],
            ['name' => 'servicesFees'],
            ['name' => 'PaymentTaxes'],
            ['name' => 'DeliveryFees'],
        ]);

        Transactions::create([
            'order_id' => $order->id,
            'type' => 1,
            'from_account_id' => 1,
            'to_account_id' => 2,
            'from_type' => 'user',
            'to_type' => 'user',
            'from_account_balance' => 3000,
            'to_account_balance' => 2500,
            'amount' => 250
        ]);
        $response = $this->get('http://localhost:8000/api/transactions');

        $response->assertStatus(201);
        $response->assertJson(array(
                'success' => true,
                'transactions' => array(
                    0 => array(
                        'id' => 1,
                        'order_id' => 1,
                        'type' => 1,
                        'from_account_id' => 1,
                        'from_type' => 'user',
                        'from_account_balance' => '3000.00',
                        'to_account_id' => 2,
                        'to_type' => 'user',
                        'to_account_balance' => '2500.00',
                        'amount' => '250.00',
                    )
                )
            )
        );
    }

    public function test_Store()
    {
        $user1 = User::create([
            'name' => 'ali',
            'email' => 'ali@eg.com',
            'password' => '1234',
            'account_id' => 1,
            'account_type' => 'user',
            'balance' => '1650.00'
        ]);
        $user2 = User::create([
            'name' => 'kareem',
            'email' => 'kareem@eg.com',
            'password' => '1234',
            'account_id' => 2,
            'account_type' => 'user',
            'balance' => '1750.00'
        ]);
        $order = Orders::create();
        DB::table('transactions_types')->insert([
            ['name' => 'MerchantFees'],
            ['name' => 'servicesFees'],
            ['name' => 'PaymentTaxes'],
            ['name' => 'DeliveryFees'],
        ]);

        $requestData = [
            'order_id' => $order->id,
            'type' => 1,
            'from_account_id' => $user1->account_id,
            'to_account_id' => $user2->account_id,
            'from_type' => $user1->account_type,
            'to_type' => $user2->account_type,
            'from_account_balance' => $user1->balance,
            'to_account_balance' => $user2->balance,
            'amount' => 250
        ];
        $response = $this->postJson('http://localhost:8000/api/transactions', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
//              'message' => 'Transaction created successfully',
            ]);
        $this->assertDatabaseHas('transactions', [
            'order_id' => $order->id,
            'type' => 1,
            'from_account_id' => $user1->account_id,
            'to_account_id' => $user2->account_id,
            'from_type' => $user1->account_type,
            'to_type' => $user2->account_type,
            'from_account_balance' => $user1->balance - $requestData['amount'],
            'to_account_balance' => $user2->balance + $requestData['amount'],
            'amount' => 250
        ]);
    }
}
