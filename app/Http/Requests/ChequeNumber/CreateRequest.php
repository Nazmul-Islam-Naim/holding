<?php

namespace App\Http\Requests\ChequeNumber;

use App\Helpers\Helper;
use App\Models\ChequeNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
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
            'cheque_book_id' => ['required'],
            'cheque_no' => ['required', 'max:20', Rule::unique(ChequeNumber::class)]
        ];
    }
}
