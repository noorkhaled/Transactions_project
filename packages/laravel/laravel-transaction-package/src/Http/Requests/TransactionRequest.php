<?php

namespace laravel\LaravelTransactionPackage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'order_id' => 'required',
            'type' => 'required',
            'fromable_account_id' => 'required|integer|min:1',
            'toable_account_id' => 'required|integer|min:1',
            'amount' => 'required|numeric',
        ];
    }
}
