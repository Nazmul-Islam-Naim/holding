<?php

namespace App\Http\Requests\BankAccount;

use App\Helpers\Helper;
use App\Models\BankAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bank_id' => ['required'],
            'account_type_id' => ['required'],
            'account_name' => ['required', 'max:50'],
            'account_number' => ['required', 'max:20', Rule::unique(BankAccount::class)->ignore(Helper::decrypt($this->bankAccount))],
            'routing_numer' => ['nullable', 'max:20'],
            'branch' => ['nullable', 'max:50'],
            'opening_date' => ['required', 'date_format:Y-m-d'],
            'balance' => ['required', 'numeric'],
        ];
    }
}
