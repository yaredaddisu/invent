<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
             'email' => ['email','required',Rule::unique('users')->ignore($this->user()->id)],
             'phone' => ['numeric','required',Rule::unique('users')->ignore($this->user()->id)],
             'is_admin' => 'boolean',
             'is_super_admin' => 'boolean',
             'status'=>'boolean',
         ];
    }
}
