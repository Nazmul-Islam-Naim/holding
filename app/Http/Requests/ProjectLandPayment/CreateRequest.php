<?php

namespace App\Http\Requests\ProjectLandPayment;

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
            'bank_account_id' => ['required'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'note' => ['nullable', 'max:255']
        ];
    }

    public function prepareForValidation(){
        return $this->merge([
            'project_id' => $this->id
        ]);
    }
}
