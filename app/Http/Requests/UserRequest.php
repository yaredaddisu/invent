<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:1000',
             'user_id' => 'exists:users,id',
             'image' => 'string|nullable',
             'secret' => 'string|nullable',
             'company' => 'string|nullable',
             'address' => 'string|nullable',
             'Vat' => 'nullable',
             'Tin' => 'nullable',
             'UserSecret' => 'string|nullable',
             'email' => ['email','required',Rule::unique('users')->ignore($this->user()->id)],
             'phone' => ['numeric','required',Rule::unique('users')->ignore($this->user()->id)],
             'is_admin' => 'boolean',
             'is_super_admin' => 'boolean',
             'status'=>'boolean',
         ];
    }
}
