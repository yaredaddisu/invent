<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required','unique:users,email,users,id' ,'string', 'max:255'],
            'phone' => 'numeric|required|unique:users,phone,user,id',
            'day_left' => ['required','date'],
            'organization'=> ['required'],
            'password' => [
                ['required','confirmed'  ],       
                         Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    //->symbols()
                    //->uncompromised()
            ],
        ];
    }
 
public function messages()
    {
        return [
            'name.required' => 'Your name is required',
            'name.min' => 'Your name must be at least 2 characters',
            'name.max' => 'Your name cannot be more than 255 characters',
            'name.string' => 'Your name must be letters only',

            'password.unique' => 'This email address is taken',

            'password.required' => 'You must create a password',
             'password.confirmed' => 'Your password confirmation does not match',
        ];
    }
}
