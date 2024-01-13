<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTypesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transactions_types')->insert([
            ['name'=>'MerchantFees'],
            ['name'=>'servicesFees'],
            ['name'=>'PaymentTaxes'],
            ['name'=>'DeliveryFees'],
        ]);
    }
}
