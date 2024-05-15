<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class purchaseRequest extends FormRequest
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
    public function rules()
    {
        return [
            'note' => 'nullable|string',
            'dateOfPurchase' => 'date|required',
            'dateOfDelivery'=>'date',
            'status' => 'required|boolean',
            'user_id' => 'exists:users,id|required',
            'supplier_id' => 'exists:suppliers,id|required',
            'purchases' => 'array|required',
            'house_id' => 'exists:warehouses,id',

        ];
    }
}
