<?php

namespace App\Http\Requests\SubType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

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
            'title' => ['required', 'string', 'max:191'],
        ];
    }

    public function prepareForValidation(){
        return $this->merge([
            'slug' => Str::slug($this->title)
        ]);
    }
}
