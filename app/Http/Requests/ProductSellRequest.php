<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductSellRequest extends FormRequest
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

  
    public function rules()
    {
        return [
            'question' => 'string',
            'type' => [ Rule::in([
                Product::TYPE_TEXT,
                Product::TYPE_TEXTAREA,
                Product::TYPE_SELECT,
                Product::TYPE_RADIO,
                Product::TYPE_CHECKBOX,
            ])],
            'description' => 'nullable|string',
            'data' => 'present',
            'totalPrice'=>'numeric',
            'total_sold'=>'numeric',
            'profit'=>'numeric|nullable',
            'sold_count'=>'numeric|nullable',
            'total_quantity'=>'numeric|nullable'          
        ];
    }
}
