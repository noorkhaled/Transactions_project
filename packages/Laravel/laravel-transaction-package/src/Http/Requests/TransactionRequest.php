<?php

namespace Laravel\LaravelTransactionPackage\Http\Requests;

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
            'order_id' => 'required',
            'type' => 'required',
            'from_account_id' => 'required|integer|min:1',
            'to_account_id' => 'required|integer|min:1',
            'from_type' => 'required|string|max:255',
            'to_type' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ];
    }
}
