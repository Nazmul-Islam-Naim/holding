<?php

namespace App\Http\Requests\Type;

use App\Models\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
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
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:191', Rule::unique(Type::class)]
        ];
    }

    public function prepareForValidation(){
        $this->merge([
            'slug' => Str::slug($this->title)
        ]);
    }
}
