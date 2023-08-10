<?php

namespace App\Http\Requests\VoucherTransaction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'date' => ['required', 'date_format:Y-m-d'],
            'amount' => ['required', 'numeric'],
            'note' => ['nullable', 'max:255'],
        ];
    }
}
