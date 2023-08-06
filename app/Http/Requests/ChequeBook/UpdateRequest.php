<?php

namespace App\Http\Requests\ChequeBook;

use App\Helpers\Helper;
use App\Models\ChequeBook;
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
            'bank_id' => ['required'],
            'title' => ['required', 'max:50'],
            'book_number' => ['required', Rule::unique(ChequeBook::class)->ignore($this->chequeBook)],
            'pages' => ['required', 'numeric']
        ];
    }
    
    public function prepareForValidation(){
        $this->merge([
            'slug' => Str::slug($this->title)
        ]);
    }
}
