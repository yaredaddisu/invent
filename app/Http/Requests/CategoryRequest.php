<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category' => 'required|string|max:1000',
            'user_id' => 'exists:users,id',
            ];
    }
}
