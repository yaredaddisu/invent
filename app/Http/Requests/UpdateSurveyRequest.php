<?php

namespace App\Http\Requests;

use App\Models\Survey;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSurveyRequest extends FormRequest
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
            'productName' => 'required|string|max:1000',
            'barCode' => 'required|string|max:1000',
            'user_id' => 'exists:users,id',
            'image'=>'nullable|nullable|string',
            'purchasePrice'=>'required',
            'salesPrice' => 'required',
            'category_id' => 'exists:categories,id',
            'quantity' => 'required|numeric',
            'code' => 'nullable|string',
            'size' => 'nullable',
            'color' => 'nullable|string',
            'brand' => ' nullable|string',
            'status' => ' boolean',
            'UserSecret' => ' required',

        ];
    }
}
