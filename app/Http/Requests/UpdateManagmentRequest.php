<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateManagmentRequest extends FormRequest
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
             'organization' => 'string|nullable',

             'house_id' => 'required',
             'email' => Rule::unique('users')->ignore($this->id),
             'password' => ['confirmed ',Rule::unique('users')->ignore($this->id)],
             'is_admin' => 'required|boolean',
             'is_super_admin' => 'required|boolean',
             'status' => 'required|boolean',
             'phone' => ['numeric',' ',Rule::unique('users')->ignore($this->id)],

        ];
    }
}
