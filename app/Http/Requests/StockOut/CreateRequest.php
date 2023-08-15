<?php

namespace App\Http\Requests\StockOut;

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
            'project_id' => ['required'],
            'date' => ['required', 'date_format:Y-m-d'],
            'note' => ['nullable'],
            'purchase_details'            =>  ['required', 'array'],
            'purchase_details.*.product_id' => ['required'],
            'purchase_details.*.unit_price' => ['required'],
            'purchase_details.*.quantity' => ['required']
        ];
    }
}
