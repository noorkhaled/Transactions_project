<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //Index function is used here to retrieve all transactions in DB
    public function index()
    {
        $transactions = Transactions::all();
        if (!$transactions) {
            return response()->json([
                'success' => false,
                'message' => "no transactions found"
            ]);
        }
        return response()->json([
            'success' => true,
            'transactions' => $transactions
        ], 201);
    }

    //store function is to create new transaction
    public function store(TransactionRequest $transactionRequest)
    {
        DB::beginTransaction();
        if (!$data = $transactionRequest->validated()) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'cannot create transaction',
            ]);
        }
        $fromableUser = User::where('account_id', $data['fromable_account_id'])->first();
        $toableUser = User::where('account_id', $data['toable_account_id'])->first();
        $data['fromable_account_type'] = $fromableUser->account_type;
        $data['toable_account_type'] = $toableUser->account_type;
        $transactions = Transactions::create($data);
        $transactions->updateBalances();
        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Transaction created successfully',
            'transaction' => $transactions
        ], 201);
    }

    //show function is used to retrieve a specific transaction by it`s ID
    public function show($id)
    {
        $transaction = Transactions::find($id);
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => "Cannot locate Transaction with ID: '$id'"
            ]);
        }
        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ], 201);
    }

}
