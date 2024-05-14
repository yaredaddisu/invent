<?php

namespace App\Http\Controllers;

use App\Http\Requests\purchaseRequest;
use App\Http\Resources\PResource;
use App\Http\Resources\purchaseResource;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class purchaseController extends Controller
{

      public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        $user = $request->user();
        $perPage = request('per_page', 10000000000);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');



        $data =  Purchase::with(['supplier'])
        ->where('user_id', $user->id)
        ->where(function($query) use ($search){
            $query->where('note', 'LIKE', '%'.$search.'%')
                  ->orWhereHas('supplier',function($query) use ($search){
                    $query->where('fullname','LIKE', '%'.$search.'%')
                     ->orWhere('phone','LIKE', '%'.$search.'%')
                     ->orWhere('address','LIKE', '%'.$search.'%')
                     ->orWhere('email','LIKE', '%'.$search.'%');


                });
        })
         ->orderBy("purchases.".$sortField, $sortDirection)
        ->paginate($perPage);

        return purchaseResource::collection($data);


     }


    public function store(purchaseRequest $request)
    {
        $data = $request->validated();




if (is_array($data['purchases'])) {
    $data['purchases'] = json_encode($data['purchases']);
}

$random = Str::random(10);
$data['slug']= Str::slug($random);




$survey = Purchase::create($data);

return new purchaseResource($survey);
    }
    public function show($id)
    {


        $purchase = Purchase::where('id', $id)->firstOrFail();
        return new PResource($purchase);    }


    public function  getById($id){
        $purchase = Purchase::where('id', $id)->firstOrFail();
        return new purchaseResource($purchase);
    }


    public function update(purchaseRequest $request, Purchase $purchase){
        $data = $request->validated();


        if (is_array($data['purchases'])) {
            $data['purchases'] = json_encode($data['purchases']);
        }

        $random = Str::random(10);
        $data['slug']= Str::slug($random);


        $purchase->update($data);

    }
    public function destroy(Purchase $product, Request $request)
    {


        $product->delete();



        return response('deleted', 204);
    }
    public function deleteAllProduct(Request $request)
    {

$id = $request->data;
foreach($id as $member){
    Purchase::where('id',$member)->delete();

}

        return response()->json([
            'message'=>"Purchase wes successfully deleted"
        ]);



   }

}
