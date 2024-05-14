<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailRequest extends FormRequest
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
     * @return array
     */
protected function prepareForValidation()
{
    $this->merge([
        'user_id' => $this->user()->id
    ]);
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Paid' => 'required|numeric',
            'PayedAmount' => 'required|numeric',
            'Due' => 'nullable',
            'Note' => 'nullable',
            'user_id' => 'exists:users,id',
           

        ];
    }
}
