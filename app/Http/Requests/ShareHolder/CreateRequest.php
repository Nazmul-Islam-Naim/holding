<?php

namespace App\Http\Requests\ShareHolder;

use App\Models\ShareHolder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:15', Rule::unique(ShareHolder::class)],
            'mail' => ['nullable', 'string', 'max:30', Rule::unique(ShareHolder::class)],
            'avatar' => ['nullable', 'image'],
            'nid' => ['nullable', 'image'],
            'details' => ['nullable'],
        ];
    }
}
