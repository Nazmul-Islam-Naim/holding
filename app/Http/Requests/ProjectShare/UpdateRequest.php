<?php

namespace App\Http\Requests\ProjectShare;

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
            'share_holder_id' => ['required'],
            'total_share' => ['required', 'numeric'],
            'date' => ['required', 'date_format:Y-m-d'],
        ];
    }
}
