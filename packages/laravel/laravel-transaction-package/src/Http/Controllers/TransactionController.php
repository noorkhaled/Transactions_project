<?php
namespace laravel\LaravelTransactionPackage\Http\Controllers;

use App\Http\Controllers\Controller;
use laravel\LaravelTransactionPackage\Http\Requests\TransactionRequest;
use laravel\LaravelTransactionPackage\Models\Transactions;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //Index function is used here to retrieve all transactions in DB
    public function index()
    {
        // Step 1: Retrieve all transactions from the database
        $transactions = Transactions::all();

        // Step 2: Check if any transactions were retrieved
        if (!$transactions) {
            // Step 3: No transactions found, return a response indicating failure
            return response()->json([
                'success' => false,
                'message' => "No transactions found"
            ]);
        }

        // Step 4: Transactions found, return a response indicating success
        return response()->json([
            'success' => true,
            'transactions' => $transactions
        ], 201);
    }

    //store function is to create new transaction
//    public function store(TransactionRequest $transactionRequest)
//    {
//        // Step 1: Begin a new database transaction
//        // DB::beginTransaction();
//
//        // Step 2: Validate the transaction request data
//        if (!$data = $transactionRequest->validated()) {
//            // Step 3: Validation failed, rollback the transaction
//            DB::rollBack();
//
//            // Step 4: Return a response indicating validation failure
//            return response()->json([
//                'success' => false,
//                'message' => 'cannot create transaction',
//            ]);
//        }
//
//        // Step 5: Fetch user data for fromable and toable accounts
//        $fromableUser = User::where('account_id', $data['fromable_account_id'])->first();
//        $toableUser = User::where('account_id', $data['toable_account_id'])->first();
//
//        // Step 6: Update user data in transaction table with account types in users table
//        $data['fromable_account_type'] = $fromableUser->account_type;
//        $data['toable_account_type'] = $toableUser->account_type;
//
//        // Step 7: Create a new transaction record in the database
//        $transaction = Transactions::create($data);
//
//        // Step 8: Update balances using the method in the Transaction model
//        $transaction->updateBalances();
//
//        // Step 9: Commit the database transaction
//        //DB::commit();
//
//        // Step 10: Return a response indicating success with the created transaction
//        return response()->json([
//            'success' => true,
//            'message' => 'Transaction created successfully',
//            'transaction' => $transaction
//        ], 201);
//    }
    public function store(TransactionRequest $transactionRequest)
    {
        DB::beginTransaction();
        // Step 1: Validate the transaction request data
        if (!$data = $transactionRequest->validated()) {
            DB::rollBack();
            // Step 2: Return a response indicating validation failure
            return response()->json([
                'success' => false,
                'message' => 'cannot create transaction',
            ]);
        }

        // Step 3: Fetch user data for fromable and toable accounts
        $fromableUser = User::where('account_id', $data['fromable_account_id'])->first();
        $toableUser = User::where('account_id', $data['toable_account_id'])->first();
        DB::commit();
        // Step 4: Update user balances and create a new transaction record
        DB::transaction(function () use ($fromableUser, $toableUser, $data) {
            // Update balances in users table
            $fromableUser->balance -= $data['amount'];
            $toableUser->balance += $data['amount'];

            // Save changes to the database
            $fromableUser->save();
            $toableUser->save();
            DB::commit();
            // Create a new transaction record in the database
            Transactions::create([
                'user_id' => $data['user_id'],
                'order_id' => $data['order_id'],
                'type' => $data['type'],
                'fromable_account_type' => $fromableUser->account_type,
                'toable_account_type' => $toableUser->account_type,
                'fromable_account_id' => $data['fromable_account_id'],
                'toable_account_id' => $data['toable_account_id'],
                'fromable_account_balance' => $fromableUser->balance,
                'toable_account_balance' => $toableUser->balance,
                'amount' => $data['amount'],
            ]);
        });
        DB::commit();
        // Step 5: Return a response indicating success
        return response()->json([
            'success' => true,
            'message' => 'Transaction created successfully',
        ], 201);
    }

    //show function is used to retrieve a specific transaction by it`s ID
    public function show($id)
    {
        // Step 1: Find the transaction with the given ID
        $transaction = Transactions::find($id);

        // Step 2: Check if the transaction exists
        if (!$transaction) {
            // Step 3: Transaction not found, return a response indicating failure
            return response()->json([
                'success' => false,
                'message' => "Cannot locate Transaction with ID: '$id'"
            ]);
        }

        // Step 4: Transaction found, return a response indicating success
        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ], 201);
    }

}
