<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $member = $this->route('member');
        if ($this->user()->id !== $member->user_id) {
            return false;
        }
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
            'fullname' => 'required|string|max:1000',
            'email' => 'string',
            'note' => ' nullable|string|max:1000',
            'user_id' => 'exists:users,id',
            'address' => 'nullable|string',
            'phone' => 'required|string|max:20',


        ];
    }
}
