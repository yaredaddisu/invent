<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id
        ]);
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:500',
            'user_id' => 'exists:users,id|required',

            'location' => 'required|string|max:500',
            'capacity' => 'required',
            'description' => ' nullable|string|max:1000',


        ];
    }
}
