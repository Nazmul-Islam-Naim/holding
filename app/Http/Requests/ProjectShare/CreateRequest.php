<?php

namespace App\Http\Requests\ProjectShare;

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
            'share_holder_id' => ['required'],
            'total_share' => ['required', 'numeric'],
            'share_amount' => ['required', 'numeric'],
            'date' => ['required', 'date_format:Y-m-d'],
        ];
    }

    public function prepareForValidation(){
        return $this->merge([
            'total_amount' => $this->total_share * $this->share_amount
        ]);
    }
}
