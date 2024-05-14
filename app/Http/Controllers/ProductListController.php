<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Cart;
use App\Models\Survey;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ProductQuestion;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductList;
use App\Http\Resources\ProductSell;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\SurveyResource;
use App\Http\Requests\ProductListRequest;
use App\Http\Requests\ProductSellRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Controllers\ProductListController;
use App\Http\Requests\UpdateProductListRequest;
use App\Http\Resources\ProductQuestionResource;

class ProductListController extends Controller
{


    public function index(Request $request)
    {

         
       $user = $request->user();
        $products = Survey::withFilters(
             request()->input('categories', []),
         )
         ->where('user_id',$user->id)
         ->orderBy('updated_at',"DESC")
         ->get();


        return SurveyResource::collection($products);

     }
 
     public function getResults(Request $request)
     {
          $user = $request->user();
          $search = request('keyword', '');
         $data = Survey::with(['category'])
         ->where('user_id', $user->id)
         ->where('productName', 'LIKE', '%'.$search.'%')
         ->orWhere('barCode', 'LIKE','%'.$search.'%')
         ->orWhere('quantity', 'LIKE', '%'.$search.'%')
         ->orWhere('salesPrice', 'LIKE', '%'.$search.'%')
         ->orWhereHas('category',function($query) use ($search){
          $query->where('category','LIKE', '%'.$search.'%');
      })
         ->get();

         
         return ProductList::collection($data);
        }


    }
     /*

     public function store( Request $request ){
        
      $product = Survey::find($request->get('survey_id'))->first();
 
      $cart = Survey::find($request->get('id'))
      ->update([
          "quantity"=> $request->get('quantity') - $request->get('decrease'),
      ]);

      $found = Survey::where('id',  $request->get('id'))->pluck('id');

      if($found){
      $cart = Cart::create([
        'survey_id'=>$product->id,
        'quantity'=>$request->get('decrease'),
        'productName'=>$request->get('productName'),
        'barCode'=>$request->get('barCode'),
        'salesPrice'=>$request->get('salesPrice'),
        'quantity'=>$request->get('quantity'),
        'purchasePrice'=>$request->get('purchasePrice'),
        'profit'=>$request->get('decrease'),
        'totalSoldPrice'=>$request->get('decrease'),
        'totalPurchsePrice'=>$request->get('decrease')

      ]);

     }
     else
     {
      return;
     }
       // $found = Survey::where('id',  $request->get('id'))->pluck('id');

      
        /*

    

  $cart = Survey::find($request->get('id'))
      ->update([
          "quantity"=>$request->get('quantity') - $request->get('decrease'),
      ]);
        $cart = Cart::where('survey_id', $request->get('survey_id'))->increment('quantity');

        

       $cart = Survey::find($request->get('id'))
       ->update([
           "quantity"=>100,
       ]);

        $id = $user->id;

        if($found->isEmpty()){
        return ;
        }else{
      $data = Survey::where('id',$request->get('id'))->decrement('quantity');

          return response()->json($data, 200);

        }

        // return response()->json($data, 200, $headers);
     }
     

    }

    */
 