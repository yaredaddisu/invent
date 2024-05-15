<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\StockInResource;
use App\Http\Resources\SurveyResource;
use App\Http\Resources\TempPrintResource;
use App\Models\Both;
use App\Models\Cart;
use App\Models\Purchase;
use App\Models\StockIn;
use App\Models\Survey;
use App\Models\TempPrint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{


    public function index(Request $request)
    {
        $search = request('search', '');
        $dateFilter = $request->keyword;
        $id = $request->id;
        $user = $request->user();
        $query = Both::query()
        ->where('user_id', $user->id)
        ->where('Transaction','=', 'Stock Out')
         ->where(function($query) use ($search){
            $query->where('productName', 'LIKE', '%'.$search.'%')
            ->orWhere('barCode','LIKE', '%'.$search.'%')
            ->orWhere('Transaction','LIKE', '%'.$search.'%')
                   ->orWhere('reference','LIKE', '%'.$search.'%');



            });


        switch($dateFilter){
                case 'today':
                    $query->whereDate('created_at',Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at',Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
                    break;
                    case 'january':
                        $query->whereMonth('created_at', 1);
                        break;
                    case 'february':
                        $query->whereMonth('created_at', 2);
                        break;
                    case 'march':
                        $query->whereMonth('created_at', 3);
                        break;
                    case 'april':
                        $query->whereMonth('created_at', 4);
                        break;
                    case 'may':
                        $query->whereMonth('created_at', 5);
                        break;
                    case 'june':
                        $query->whereMonth('created_at', 6);
                        break;
                    case 'july':
                        $query->whereMonth('created_at', 7);
                        break;
                    case 'august':
                        $query->whereMonth('created_at', 8);
                        break;
                    case 'september':
                        $query->whereMonth('created_at', 9);
                        break;
                    case 'october':
                        $query->whereMonth('created_at', 10);
                        break;
                    case 'november':
                        $query->whereMonth('created_at', 11);
                        break;
                    case 'december':
                        $query->whereMonth('created_at', 12);
                        break;
            }
        $data = $query->orderBy('updated_at',"DESC")->get();



        return CartResource::collection($data);





     }

     public function getStockIn(Request $request)
    {
        $user = $request->user();

                $search = request('search', '');
                $dateFilter = $request->keyword;

        $query = Both::query()
        ->where('user_id', $user->id)
        ->where('Transaction','=', 'Stock In')
         ->where(function($query) use ($search){
            $query->where('productName', 'LIKE', '%'.$search.'%')
            ->orWhere('barCode','LIKE', '%'.$search.'%')
            ->orWhere('reference','LIKE', '%'.$search.'%');

            });

        switch($dateFilter){
                case 'today':
                    $query->whereDate('created_at',Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at',Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
                    break;
                    case 'january':
                        $query->whereMonth('created_at', 1);
                        break;
                    case 'february':
                        $query->whereMonth('created_at', 2);
                        break;
                    case 'march':
                        $query->whereMonth('created_at', 3);
                        break;
                    case 'april':
                        $query->whereMonth('created_at', 4);
                        break;
                    case 'may':
                        $query->whereMonth('created_at', 5);
                        break;
                    case 'june':
                        $query->whereMonth('created_at', 6);
                        break;
                    case 'july':
                        $query->whereMonth('created_at', 7);
                        break;
                    case 'august':
                        $query->whereMonth('created_at', 8);
                        break;
                    case 'september':
                        $query->whereMonth('created_at', 9);
                        break;
                    case 'october':
                        $query->whereMonth('created_at', 10);
                        break;
                    case 'november':
                        $query->whereMonth('created_at', 11);
                        break;
                    case 'december':
                        $query->whereMonth('created_at', 12);
                        break;
            }
        $data = $query->orderBy('updated_at',"DESC")->get();



        return StockInResource::collection($data);





     }

     public function getSum(Request $request)
     {
         $user = $request->user();
         $query = DB::table('boths')
         ->where('Transaction','=', 'Stock Out')
         ->where('user_id',$user->id);

         $dateFilter = $request->keyword;

         switch($dateFilter){
            case 'today':
                $query->whereDate('created_at',Carbon::today())->sum('totalStockOutPrice');
                break;
            case 'yesterday':
                $query->wheredate('created_at',Carbon::yesterday())->sum('totalStockOutPrice');
                break;
            case 'this_week':
                $query->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('totalStockOutPrice');
                break;
            case 'last_week':
                $query->whereBetween('created_at',[Carbon::now()->subWeek(),Carbon::now()])->sum('totalStockOutPrice');
                break;
            case 'this_month':
                $query->whereMonth('created_at',Carbon::now()->month)->sum('totalStockOutPrice');
                break;
            case 'last_month':
                $query->whereMonth('created_at',Carbon::now()->subMonth()->month)->sum('totalStockOutPrice');
                break;
            case 'this_year':
                $query->whereYear('created_at',Carbon::now()->year)->sum('totalStockOutPrice');
                break;


         }

         $data = $query->sum('totalStockOutPrice');



         return $data;

      }
   public function getStockInSum(Request $request)
      {
          $user = $request->user();
          $query = DB::table('boths')
          ->where('Transaction','=', 'Stock In')
          ->where('user_id',$user->id);

          $dateFilter = $request->keyword;

          switch($dateFilter){
             case 'today':
                 $query->whereDate('created_at',Carbon::today())->sum('quantity');
                 break;
             case 'yesterday':
                 $query->wheredate('created_at',Carbon::yesterday())->sum('quantity');
                 break;
             case 'this_week':
                 $query->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('quantity');
                 break;
             case 'last_week':
                 $query->whereBetween('created_at',[Carbon::now()->subWeek(),Carbon::now()])->sum('quantity');
                 break;
             case 'this_month':
                 $query->whereMonth('created_at',Carbon::now()->month)->sum('quantity');
                 break;
             case 'last_month':
                 $query->whereMonth('created_at',Carbon::now()->subMonth()->month)->sum('quantity');
                 break;


          }

          $data = $query->sum('quantity');



          return $data;

       }

      public function getStockedSum(Request $request)
      {
          $user = $request->user();
          $query = DB::table('boths')
          ->where('Transaction','=', 'Stock Out')
          ->where('user_id',$user->id);

          $dateFilter = $request->keyword;

          switch($dateFilter){
             case 'today':
                 $query->whereDate('created_at',Carbon::today())->sum('quantity');
                 break;
             case 'yesterday':
                 $query->wheredate('created_at',Carbon::yesterday())->sum('quantity');
                 break;
             case 'this_week':
                 $query->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('quantity');
                 break;
             case 'last_week':
                 $query->whereBetween('created_at',[Carbon::now()->subWeek(),Carbon::now()])->sum('quantity');
                 break;
             case 'this_month':
                 $query->whereMonth('created_at',Carbon::now()->month)->sum('quantity');
                 break;
             case 'last_month':
                 $query->whereMonth('created_at',Carbon::now()->subMonth()->month)->sum('quantity');
                 break;


          }

          $data = $query->sum('quantity');



          return $data;

       }

     public function getCount(Request $request)
     {
        $user = $request->user();

        $todayCount = DB::table('surveys')
        ->where('user_id',$user->id)
        ->sum('quantity');


        $todayStockOut = DB::table('boths')
        ->where('user_id',$user->id)
        ->whereDate('created_at',Carbon::today())
        ->sum('quantity');



        return[
            'todayCount'=>$todayCount,
            'todayStockOut'=>$todayStockOut,

         ];


         }


     public  function todayCart(Request $request){
        $user = $request->user();

        return Carbon::now()->toDateString();



    }


    public function store(CartRequest $request)
    {
        $data = $request->validated();



  foreach ($data['cart'] as $question) {

     if ($question['productQuantity'] < $question['quantity']) {
        return response([
            'error' => 'You dont have products in Stock'
        ], 422);

    }else{
        $this->createCart($question);

    }

}

    }

private function createCart($data)
{

    $cart = Survey::find($data['id'])
->update([
    "quantity"=> $data['productQuantity'] - $data['quantity'],
]);



if (isset($data['profit'])) {
    $data['profit'] =   ($data['salesPrice'] -  $data['purchasePrice']) * $data['quantity'] ;
}
if (isset($data['remaining'])) {
    $data['remaining'] =  $data['productQuantity'] - $data['quantity'] ;
}
if (isset($data['previous'])) {
    $data['previous'] =  $data['productQuantity'];
}
if (isset($data['totalStockOutPrice'])) {
    $data['totalStockOutPrice'] =  $data['salesPrice'] * $data['quantity'] ;
}


if (isset($data['quantity'])) {
    $data['quantity'] = - $data['quantity'];
}




$car = $validator = Validator::make($data, [
    'user_id'=>'exists:App\Models\User,id',
    'survey_id' => 'exists:App\Models\Survey,id',
    'productName'=>'string',
    //'house_id'=>'exists:App\Models\Warehouse,id',
    'barCode'=>' ',
    'salesPrice'=>'numeric',
    'quantity'=>'numeric',
    'purchasePrice'=>'numeric',
    'profit'=>'numeric',
    "remaining"=> 'numeric',
    "previous"=>'numeric',
    "totalStockOutPrice"=>'numeric',
    "Transaction"=>'String',
    'creator'=>'required',
'reference'=>''


]);



//$survey = Cart::create($validator->validated());
$survey =  Both::create($validator->validated());

return new TempPrintResource($survey);

}

public function StockIn(CartRequest $request){
    $data = $request->validated();


    //$product = Product::create($data);

     foreach ($data['cart'] as $question) {




        $this->bothstockIn($question);
   }
}

private function bothstockIn($data)
{



    $cart = Survey::find($data['id'])
->update([
    "quantity"=> $data['productQuantity'] + $data['quantity'],
    "salesPrice"=>$data['salesPrice'],
    "purchasePrice"=>$data['purchasePrice'],

]);

//return new SurveyResource($cart);

if (isset($data['remaining'])) {
    $data['remaining'] =  $data['productQuantity'] + $data['quantity'] ;
}
if (isset($data['previous'])) {
    $data['previous'] =  $data['productQuantity'];
}

$validator = Validator::make($data, [
    'user_id'=>'exists:App\Models\User,id',
    'survey_id' => 'exists:App\Models\Survey,id',
    //'house_id'=>'exists:App\Models\Warehouse,id',
    'creator'=>'required',
    'productName'=>'string',
    'salesPrice'=>'numeric',
    'purchasePrice'=>'numeric',
    'barCode'=>' ',
    "remaining"=> 'numeric',
    "previous"=>'numeric',
    'quantity'=>'numeric',
    "Transaction"=>'String',
    'reference'=>''



]);

//$survey = StockIn::create($validator->validated());
$survey = Both::create($validator->validated());

return new StockInResource($survey);



}
public function update(CartRequest $request)
{
    $data = $request->validated();

    foreach ($data['cart'] as $item) {
        // Validate each item against the defined rules
        $validator = Validator::make($item, [
            'user_id' => 'exists:users,id',
            'survey_id' => 'exists:surveys,id',
           // 'house_id' => 'exists:warehouses,id',
            'creator' => 'required',
            'productName' => 'string',
            'salesPrice' => 'numeric',
            'purchasePrice' => 'numeric',
            'barCode' => 'string|nullable',
            'remaining' => 'numeric',
            'previous' => 'numeric',
            'quantity' => 'numeric',
            'Transaction' => 'string',
            'reference' => 'string|nullable',
            'updated' => 'boolean',

            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            // Handle validation errors (e.g., return a response indicating validation failure)
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }



        // Calculate the remaining value for the item
        $remaining = $item['previous'] + $item['quantity'];
        $quantity = $item['quantity'];
        $previous = $item['previous'];

        if( $item['Transaction'] == "Stock Out"){
            $totalStockOutPrice = $item['salesPrice'] * $item['quantity']  * -1;
            $profit = (($item['salesPrice'] -  $item['purchasePrice']) * $item['quantity'] ) * -1;

        }

        // Update the item in the database
        $cartItem = Both::findOrFail($item['id']);
        $cartItem->remaining = $remaining;
                $cartItem->quantity = $quantity;
                $cartItem->previous = $previous;
                if( $item['Transaction'] == "Stock Out"){
                    $cartItem->profit = $profit;
                    $cartItem->totalStockOutPrice = $totalStockOutPrice;
                }

                $cartItem->updated = 1;

        $cartItem->save();
    }

    // Return a success response if all items are updated successfully
    return response()->json(['message' => 'Cart items updated successfully']);
}

public function show(Both $cart, Request $request)
{


    return new CartResource($cart);
}

/*
public function allProducts()
{
    return Cart::pluck('id');
}


public function export($students)
{
    $studentsArray = explode(',',$students);
    return (new ProductExport($studentsArray))->download('students.xlsx');
}

*/
public function deleteAll(Request $request)
{
    $user = $request->user();

    $credentials = $request->validate([
         'UserSecret' => 'required',
    ]);



    if(!Hash::check($request->UserSecret,$user->secret)){
        return response([
            'error' => 'Secret Word  is incorrect'
        ], 422);
    }else{
        $id = $request->data;
        foreach($id as $cart){
        Both::where('id',$cart)->delete();

    }
}



    return response('', 204);


}


}
