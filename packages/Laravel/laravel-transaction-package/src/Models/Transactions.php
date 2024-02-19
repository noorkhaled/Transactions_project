<?php

namespace Laravel\LaravelTransactionPackage\Models;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Laravel\LaravelTransactionPackage\Http\Requests\TransactionRequest;


/**
 * @method static create(array $array)
 * @method static find($id)
 */
class Transactions extends Model
{
    use HasFactory;

    //Here are the fillable attributes that required when you want to create a new transaction
    protected $fillable = [
        //the order_id that this transaction will belong to
        'order_id',
        //the type of the transaction
        'type',
        //the account will send the transaction
        'from_type',
        //the account will receive this transaction
        'to_type',
        //the account_id of transaction`s sender
        'from_account_id',
        //the account_id of transaction`s receiver
        'to_account_id',
        //the account_balance of transaction`s sender
        'from_account_balance',
        //the account_balance of transaction`s receiver
        'to_account_balance',
        //the amount of this transaction
        'amount',
    ];
    protected $table = 'transactions';

    //relation between user and transaction that every transaction belong to user

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //relation between order and transaction that every transaction should belong to an order

    /**
     * @return BelongsTo
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Orders::class);
    }

    /**
     * performTransaction
     * @param TransactionRequest $transactionRequest
     * @return mixed
     */
    public static function performTransaction(TransactionRequest $transactionRequest): mixed
    {
        $data = $transactionRequest->validated();
        //Assign the type of (from) account from config file
        $from = Config::get('transactions.accountTypes.' . $data['from_type']);
        //Assign the type of (to) account from config file
        $to = Config::get('transactions.accountTypes.' . $data['to_type']);

        $fromAccount = $from['model']::where($from['foreignKey'], $data['from_account_id'])->first();
        $toAccount = $to['model']::where($to['foreignKey'], $data['to_account_id'])->first();

        $fromAccount->balance -= $data['amount'];
        $toAccount->balance += $data['amount'];

        // Save changes to the database
        $fromAccount->save();
        $toAccount->save();

        // Create a new transaction record in the database
        return Transactions::create([
            'order_id' => $data['order_id'],
            'type' => $data['type'],
            'from_type' => $data['from_type'],
            'to_type' => $data['to_type'],
            'from_account_id' => $data['from_account_id'],
            'to_account_id' => $data['to_account_id'],
            'from_account_balance' => $fromAccount->balance,
            'to_account_balance' => $toAccount->balance,
            'amount' => $data['amount'],
        ]);
    }

    /**
     * getUserTransactions is a function for loading and displaying all user transaction in web view
     * @param $id
     * @return array
     */
    public static function getUserTransactions($id): array
    {
        $user = User::findOrFail($id);

        $transactions = DB::table('transactions')
            ->where('from_account_id', '=', $user->account_id)
            ->orWhere('to_account_id', '=', $user->account_id)
            ->join('transactions_types', 'transactions.type', '=', 'transactions_types.id')
            ->select('transactions.*', 'transactions_types.name as type_name')
            ->orderBy('created_at', 'desc')
            ->get();

        $accountStatements = [];

        foreach ($transactions as $transaction) {
            $sent = $transaction->from_account_id === $user->account_id;
            $accountBalanceBefore = $sent ?
                $transaction->from_account_balance + $transaction->amount : $transaction->to_account_balance - $transaction->amount;
            $accountBalanceAfter = $sent ?
                $accountBalanceBefore - $transaction->amount : $accountBalanceBefore + $transaction->amount;

            $accountStatements[] = [
                'Transaction_Id' => $transaction->id,
                'Transaction_Date' => $transaction->created_at,
                'Transaction_Type' => $transaction->type_name,
                'Receiver_account' => $sent ?
                    $transaction->to_account_id : $transaction->from_account_id,
                'Account_Balance_Before' => $accountBalanceBefore,
                'Transaction_Amount' => $sent ?
                    '- ' . $transaction->amount : '+ ' . $transaction->amount,
                'Account_Balance_After' => $accountBalanceAfter,
            ];
        }
        return $accountStatements;
    }

}
