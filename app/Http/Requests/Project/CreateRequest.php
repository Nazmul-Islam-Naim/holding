<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
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
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', Rule::unique(Project::class)],
            'location' => ['nullable', 'string', 'max:255'],
            'land_owner' => ['required', 'string', 'max:255'],
            'land_amount' => ['required', 'string', 'max:255'],
            'land_cost' => ['required', 'numeric'],
            'description' => ['nullable'],
            'total_share' => ['required', 'numeric'],
            'avatar' => ['nullable', 'image'],
            'document' => ['nullable', 'mimes:pdf,image'],
        ];
    }

    public function prepareForValidation(){
        return $this->merge([
            'slug' => Str::slug($this->title)
        ]);
    }
}
