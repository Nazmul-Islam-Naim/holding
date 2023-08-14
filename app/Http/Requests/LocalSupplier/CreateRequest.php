<?php

namespace App\Http\Requests\LocalSupplier;

use App\Models\LocalSupplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'max:15', Rule::unique(LocalSupplier::class)],
            'email' => ['nullable', 'max:50', Rule::unique(LocalSupplier::class)],
            'address' => ['nullable'],
        ];
    }
}
