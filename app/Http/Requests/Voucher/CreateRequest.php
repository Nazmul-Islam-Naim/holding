<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'type_id' => ['required'],
            'sub_type_id' => ['required'],
            'voucher_type' => ['required'],
            'bearer' => ['nullable', 'max:191'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date_format:Y-m-d'],
            'note' => ['nullable', 'max:255'],
        ];
    }

    public function prepareForValidation(){
        return $this->merge([
            'due' => $this->amount
        ]);
    }
}
