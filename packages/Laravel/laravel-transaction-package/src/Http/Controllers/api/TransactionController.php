<?php

namespace Laravel\LaravelTransactionPackage\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Laravel\LaravelTransactionPackage\Http\Requests\TransactionRequest;
use Laravel\LaravelTransactionPackage\Models\Transactions;

class TransactionController extends Controller
{
    /**
     * index function is a function fol listing and retrieving all available transactions found in Database
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Step 1: Retrieve all transactions from the database
        $transactions = Transactions::all();
        // Step 2: Check if any transactions were retrieved
        if (!$transactions) {
            // Step 3: No transactions found, return a response indicating failure
            return response()->json([
                'success' => false,
                'message' => 'false',
                'message*' => trans('messages.no_transactions_found')
            ]);
        }
        // Step 4: Transactions found, return a response indicating success
        return response()->json([
            'success' => true,
            'message' => 'success',
            'transactions' => $transactions
        ], 201);
    }

    /**
     * store function is a function that responsible for creating new transaction
     * it takes one param transactionRequest that used for validating transaction Data
     * @param TransactionRequest $transactionRequest
     * @return JsonResponse
     */
    public function store(TransactionRequest $transactionRequest): JsonResponse
    {
        try {
            //start the Database transaction by using function beginTransaction
            DB::beginTransaction();

            $transactions = Transactions::performTransaction($transactionRequest);
            //save the transaction in database
            DB::commit();
            // Return a response indicating success
            return response()->json([
                'success' => true,
                'message' => trans('messages.transaction_created_successfully'),
                'Transaction' => $transactions
            ], 201);
        } catch (Exception $e) {
            //Rollback if any Exception thrown
            DB::rollBack();
            // Handle any exceptions and return a response indicating failure
            return response()->json([
                'success' => false,
                'message' => trans('messages.error_creating_transaction'),
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * show function is a function that take an id of specific transaction as a param and retrieve this transaction data from Database
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        // Step 1: Find the transaction with the given ID
        $transaction = Transactions::find($id);

        // Step 2: Check if the transaction exists
        if (!$transaction) {
            // Step 3: Transaction not found, return a response indicating failure
            return response()->json([
                'success' => false,
                'message' => trans('messages.cannot_locate_Transaction_ID') . "$id"
            ]);
        }
        // Step 4: Transaction found, return a response indicating success
        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ], 201);
    }
}
