<?php

namespace App\Http\Controllers;

use App\Models\Both;
use App\Models\Cart;
use App\Models\StockIn;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MergeReportsController extends Controller
{

    public function index(Request $request)
{
    $search = request('search', '');
    $dateFilter = $request->keyword;
    $id = $request->id;


    // Retrieve data from both tables
    $query = StockIn::where('user_id',$id)
    ->where(function($query) use ($search){
        $query->where('productName', 'LIKE', '%'.$search.'%')
        ->orWhere('barCode','LIKE', '%'.$search.'%')
        ->orWhere('Transaction','LIKE', '%'.$search.'%');

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

            $data1 = $query
                ->with('house') // Eager load the house relationship with only the 'name' column

            ->orderBy('productName', 'ASC')
            ->select('creator','productName','house_id', 'barCode', 'purchasePrice','salesPrice', 'previous', 'quantity','remaining','Transaction', 'created_at', 'updated_at')
            ->get()
            ->map(function ($item) {
                // Format the created_at and updated_at columns
                $item['created_at'] = $item['created_at']->format('Y-m-d H:i:s');
                $item['updated_at'] = $item['updated_at']->format('Y-m-d H:i:s');

                return $item;
            });

    $query = Both::where('user_id',$id)
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



            $data2 = $query
                ->with('house') // Eager load the house relationship with only the 'name' column

            ->orderBy('updated_at', 'DESC')
            ->select('reference','creator','house_id','productName', 'barCode', 'productName', 'purchasePrice','salesPrice', 'previous', 'quantity','remaining','profit','totalStockOutPrice','Transaction', 'created_at', 'updated_at')
            ->get()
            ->map(function ($item) {
                $item['created_at'] = $item['created_at']->format('Y-m-d H:i:s'); // Example: 2024-04-02 12:22:31
                $item['updated_at'] = $item['updated_at']->format('Y-m-d H:i:s');

                return $item;
            });

     $data3 = array_merge($data1->toArray(), $data2->toArray());



    return response()->json([
        "data"=>$data2
    ]);
}
}
