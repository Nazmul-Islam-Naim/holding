<?php

namespace App\Http\Requests\BankAccount;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bank_account_id' => ['required'],
            'amount' => ['required', 'numeric'],
            'transaction_date' => ['required', 'date_format:Y-m-d'],
            'note' => ['nullable', 'max:255']
        ];
    }
}
