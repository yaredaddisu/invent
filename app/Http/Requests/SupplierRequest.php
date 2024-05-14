<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id
        ]);
    }

    public function rules()
    {
        return [
            'fullname' => 'required|string|max:50',
            'address' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'note' => ' nullable|string|max:1000',
            'user_id' => 'exists:users,id',
            'email' => 'required|email',


        ];
    }
}
