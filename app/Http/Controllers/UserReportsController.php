<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserReportsResource;
use App\Models\Both;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserReportsController extends Controller
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


        $query = Both::with('house')
            ->selectRaw('
                MAX(id) as id,
                 productName,
                barCode,
                house_id,
                user_id,
                MAX(creator) as creator,
                MAX(purchasePrice) as purchasePrice,
                MAX(salesPrice) as salesPrice,
                MAX(previous) as previous,

                SUM(quantity) as quantity,
                 SUM(profit) as profit,
                SUM(totalStockOutPrice) as totalStockOutPrice,
                MAX(Transaction) as Transaction,
                MAX(created_at) as created_at,
                (SELECT remaining FROM carts AS c2 WHERE c2.productName = carts.productName AND c2.barCode = carts.barCode AND c2.user_id = carts.user_id ORDER BY c2.updated_at DESC LIMIT 1) as remaining
            ')
            ->where('user_id',$id)
            ->where('Transaction',"Stock Out")

             ->groupBy('productName', 'barCode','user_id','house_id'   )

            ->where(function($query) use ($search) {
                $query->where('productName', 'LIKE', '%'.$search.'%')
                    ->orWhereHas('house', function($query) use ($search) {
                        $query->where('name','LIKE', '%'.$search.'%');
                    });
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


            $data = $query->orderBy($sortField, $sortDirection)
            ->paginate($perPage);





        return UserReportsResource::collection($data);
    ;

     }
     public function show($id)
     {


         $purchase = User::where('id', $id)->firstOrFail();
         return new UserReportsResource($purchase);

        }


}
