<?php

namespace App\Http\Requests\ProductCategory;

use App\Models\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            'title' => ['required', 'max:191', Rule::unique(ProductCategory::class)->ignore($this->productCategory)] 
        ];
    }

    public function prepareForValidation(){
        return $this->merge([
            'slug' => Str::slug($this->title)
        ]);
    }
}
