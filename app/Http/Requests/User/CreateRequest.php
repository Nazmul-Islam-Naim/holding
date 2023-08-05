<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', Rule::unique(User::class)],
            'phone' => ['nullable', 'max:15', Rule::unique(User::class)],
            'password' => ['required', 'confirmed', Password::min(6)
                                                ->letters()
                                                ->mixedCase()
                                                ->numbers()],
            'role_id' => ['required'],
            'avatar' => ['nullable', 'image'],
            'nid' => ['nullable', 'image']
        ];
    }
}
