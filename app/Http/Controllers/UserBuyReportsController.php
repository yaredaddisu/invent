<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserBuyReportsResource;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserBuyReportsController extends Controller
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
            ->where('user_id',$id)

            ->where(function($query) use ($search) {
                $query->where('dateOfPurchase', 'LIKE', '%'.$search.'%')
                    ->orWhereHas('supplier', function($query) use ($search) {
                        $query->where('fullname','LIKE', '%'.$search.'%');
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





        return UserBuyReportsResource::collection($data);
    ;

     }


     public function show($id)
     {


         $purchase = User::where('id', $id)->firstOrFail();
         return new UserBuyReportsResource($purchase);

        }
}
