<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserManagmentRequest extends FormRequest
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
             'email'=>'email',
             'is_admin' => 'boolean',
             'status' => 'boolean',
             'house_id' => 'required',
             'password' => [
                ['required','confirmed'  ],
                         Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                   // ->symbols()
                    //->uncompromised()
            ],
                'is_super_admin' => 'boolean',
             'phone' => 'numeric|required|string|unique:users,phone,user,id',

             'organization' => 'required',

              'day_left' => 'nullable|date',
        ];
    }
}
