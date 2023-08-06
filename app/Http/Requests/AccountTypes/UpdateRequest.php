<?php

namespace App\Http\Requests\AccountTypes;

use App\Actions\Identifier;
use App\Helpers\Helper;
use App\Models\AccountType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:191', Rule::unique(AccountType::class)->ignore(Helper::decrypt($this->accountType))]
        ];
    }
    
    public function prepareForValidation(){
        $this->merge([
            'slug' => Str::slug($this->title)
        ]);
    }
}
