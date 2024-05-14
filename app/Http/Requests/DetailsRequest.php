<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailsRequest extends FormRequest
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
            'Reference' => 'string',
            'tax' => 'required|numeric',
            'amount' => 'required|numeric',
            'shipping' => 'required|numeric',
            'TotalQuantity' => 'required|numeric',
            'TotalProduct' => 'required|numeric',
            'PayedAmount' => 'required|numeric',
            'Tin' => 'nullable',
            'Vat' => 'nullable',
            'Note' => 'nullable',
            'Due' => 'nullable',
            'GrandTotal' => 'nullable',
            'name' => 'string|nullable',
            'email' => 'string|nullable',
            'phone' => 'numeric|nullable',
            'address' => 'string|nullable',
            'paymentMethod' => 'string|nullable',
            'status' => 'boolan',
            'user_id' => 'exists:users,id',
            'questions' => 'array',
            

        ];
    }
}
