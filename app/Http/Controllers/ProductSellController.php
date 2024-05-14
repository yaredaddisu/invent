<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\ProductQuestion;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductSell;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Validator;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductSellRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductQuestionResource;

class ProductSellController extends Controller
{
  
    public function index(Request $request)
    {
         $perPage = request('per_page', 10000000000);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

 
        $data =  DB::table('product_questions') 
         //->join('products', 'products.id', '=', 'product_questions.product_id')
        ->where(function($query) use ($search){
            $query->where('question', 'LIKE', '%'.$search.'%');
                   
        })
         ->orderBy("product_questions.".$sortField, $sortDirection)
        ->paginate($perPage);

        return ProductQuestion::collection($data);

    }

  
    public function show($id, Request $request)
    {

       // $user = $request->user();
 

        $product = ProductQuestion::find($id);

        return new  ProductQuestionResource($product);
    }

    public function store(ProductSellRequest $request)
    {
        
        $data = $request->validated();
        

        $user = ProductQuestion::create($data);

        return new ProductQuestionResource($user);
    }
           
    public function update($id, ProductSellRequest $request)
    {
 
        $data = $request->validated();
        $product = ProductQuestion::find($id);

        $product->update($data);


 
        return new  ProductQuestionResource($product);

 }


       
    
}
