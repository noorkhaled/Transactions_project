<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string',
            'account_id' => 'required|integer|min:1',
            'account_type' => 'required|string|max:255',
            'balance' => 'required|numeric'
        ];
    }
}
