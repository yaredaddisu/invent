<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserBuyReportsResource;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserPurchaseReportsController extends Controller
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
        $id = request('id');

        $dateFilter = $request->keyword;


        $query = Purchase::with('supplier')
            ->where('id',$id)
            ->where(function($query) use ($search) {
                $query->where('dateOfPurchase', 'LIKE', '%'.$search.'%')
                ->orWhere('dateOfDelivery', 'LIKE', '%'.$search.'%')
                    ->orWhereHas('supplier', function($query) use ($search) {
                        $query->where('fullname','LIKE', '%'.$search.'%');
                    });
            });




            $data = $query->orderBy($sortField, $sortDirection)
            ->paginate($perPage);





        return UserBuyReportsResource::collection($data);
    ;

     }
     public function show($id)
     {


         $purchase = Purchase::where('id', $id)->firstOrFail();
         return new UserBuyReportsResource($purchase);

        }


}
