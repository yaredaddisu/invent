<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailsRequest;
use App\Http\Requests\UpdateDetailRequest;
use App\Http\Resources\DetailsResource;
use App\Models\Both;
use App\Models\Cart;
use App\Models\Details;
use App\Models\Survey;
use App\Models\TempPrint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DetailsController extends Controller
{






    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = request('per_page', 10000000000);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
       // $dateFilter = request('keyword');



        $query =  Details::with(['questions'])
        ->where('user_id', $user->id)
        ->where(function($query) use ($search){
            $query->where('Reference', 'LIKE', '%'.$search.'%')
            ->orWhere('paymentMethod', 'LIKE', '%'.$search.'%')
                   ->orWhereHas('questions',function($query) use ($search){
                    $query->where('productName','LIKE', '%'.$search.'%');
                });
        });



        $dateFilter = $request->keyword;

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

        $data = $query->orderBy("details.".$sortField, $sortDirection)
        ->paginate($perPage);



        return DetailsResource::collection($data);





     }


    public function store(DetailsRequest $request)
    {

        $data = $request->validated();

        if (isset($data['Due'])) {
            if($data['GrandTotal'] < $data['PayedAmount']){
                return response([
                    'error' => 'Paying Amount must be less than Received Amount
                    '
                ], 422);
            }else{
                $data['Due'] =   ($data['GrandTotal'] -  $data['PayedAmount']) ;

            }
        }
        $detail = Details::create($data);



            // Create new questions
            foreach ($data['questions'] as $cart) {
                $cart['details_id'] = $detail->id;

            if ($cart['productQuantity'] < $cart['quantity']) {
                return response([
                    'error' => 'You do not have products in Stock'
                ], 422);

            }else{
                $this->createTemps($cart);

            }
            }
            if($detail){
                return response([
                    'success' => 'Product was successfully Stocked Out '
                ], 200);
            }

        return new DetailsResource($detail);


    }



    private function createTemps($data)
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


    $validator = Validator::make($data, [
        'details_id' => 'exists:App\Models\Details,id',
        'user_id'=>'exists:App\Models\User,id',
        'survey_id' => 'exists:App\Models\Survey,id',
        'productName'=>'string',
        //'house_id'=>'exists:App\Models\Warehouse,id',
        'creator'=>'required',
        'barCode'=>' ',
        'salesPrice'=>'numeric',
        'quantity'=>'numeric',
        'purchasePrice'=>'numeric',
        'profit'=>'numeric',
        "remaining"=> 'numeric',
        "previous"=>'numeric',
        "totalStockOutPrice"=>'numeric',
        "Transaction"=>'String',
        "reference"=>' ',


    ]);
    //Both::create($validator->validated());

    return Both::create($validator->validated());
    }


    public function show($id) {
        $details = Details::find($id);
        return new DetailsResource($details);
    }


    public function deleteAllDetail(Request $request)
    {



 $id = $request->data;
 foreach($id as $detail){
    Details::where('id',$detail)->delete();

 }




        return response('', 204);


    }

    public function update(UpdateDetailRequest $request, Details $detail)
    {

      $data = $request->validated();
      if($data['Due'] < $data['Paid']){
        return response([
            'error' => '
            The amount you input should not exceed the amount of the Due '
        ], 422);
    }else{



      if (isset($data['Due'])) {

        $data['Due'] =   ($data['Due'] -  $data['Paid'])  ;
    }

    if (isset($data['PayedAmount'])) {
        $data['PayedAmount'] =   ($data['PayedAmount'] + $data['Paid'])  ;
    }
    if (isset($data['Note']) == null) {
        $data['Note'] =  $data['note'];
    }

}

        $detail->update($data);

        if ($data) {
            return response()->json(['success'=>'Payment updated successfully']);
        } else {
            return response()->json(['error'=>'Payment Not updated successfully']);
        }

        return new DetailsResource($detail);
    }

}
