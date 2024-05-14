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
        $search = $request->input('search', '');
        $dateFilter = $request->input('keyword');
        $id = $request->input('id');

        // Retrieve data from StockIn table
        $stockInData = StockIn::with('house')
        ->leftJoin('warehouses', 'stock_ins.house_id', '=', 'warehouses.id')
        ->where('stock_ins.user_id', $id)
        ->selectRaw('
            MAX(stock_ins.id) as id,
            stock_ins.house_id,
            stock_ins.productName,
            stock_ins.barCode,
            MAX(stock_ins.creator) as creator,
            MAX(stock_ins.purchasePrice) as purchasePrice,
            MAX(stock_ins.salesPrice) as salesPrice,
            MAX(stock_ins.remaining) as remaining,
              (SELECT c2.quantity FROM stock_ins AS c2 WHERE c2.productName = stock_ins.productName AND c2.barCode = stock_ins.barCode ORDER BY c2.updated_at DESC LIMIT 1) as quantity,
             (SELECT c2.previous FROM stock_ins AS c2 WHERE c2.productName = stock_ins.productName AND c2.barCode = stock_ins.barCode ORDER BY c2.updated_at DESC LIMIT 1) as previous,

              MAX(stock_ins.Transaction) as Transaction,
                MAX(stock_ins.created_at) as created_at,
                MAX(stock_ins.updated_at) as updated_at,
                (SELECT remaining FROM stock_ins AS c2 WHERE c2.productName = stock_ins.productName AND c2.barCode = stock_ins.barCode ORDER BY c2.updated_at DESC LIMIT 1) as remaining
            ')
            ->groupBy('stock_ins.productName', 'stock_ins.barCode', 'stock_ins.house_id')
            ->where(function ($query) use ($search) {
                $query->where('productName', 'LIKE', '%' . $search . '%')
                    ->orWhere('barCode', 'LIKE', '%' . $search . '%')
                     ->orWhere('Transaction', 'LIKE', '%' . $search . '%');
            })
        ->when($dateFilter, function ($query, $dateFilter) {
            switch($dateFilter){
                case 'today':
                    $query->whereDate('stock_ins.created_at',Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('stock_ins.created_at',Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('stock_ins.created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
                    break;
                    case 'january':
                        $query->whereMonth('stock_ins.created_at', 1);
                        break;
                    case 'february':
                        $query->whereMonth('stock_ins.created_at', 2);
                        break;
                    case 'march':
                        $query->whereMonth('stock_ins.created_at', 3);
                        break;
                    case 'april':
                        $query->whereMonth('stock_ins.created_at', 4);
                        break;
                    case 'may':
                        $query->whereMonth('stock_ins.created_at', 5);
                        break;
                    case 'june':
                        $query->whereMonth('stock_ins.created_at', 6);
                        break;
                    case 'july':
                        $query->whereMonth('stock_ins.created_at', 7);
                        break;
                    case 'august':
                        $query->whereMonth('stock_ins.created_at', 8);
                        break;
                    case 'september':
                        $query->whereMonth('stock_ins.created_at', 9);
                        break;
                    case 'october':
                        $query->whereMonth('stock_ins.created_at', 10);
                        break;
                    case 'november':
                        $query->whereMonth('stock_ins.created_at', 11);
                        break;
                    case 'december':
                        $query->whereMonth('stock_ins.created_at', 12);
                        break;
            }

        })
        ->get();

        // Retrieve data from Cart table
     // Retrieve data from Cart table
     $cartData = Both::with('house')
     ->leftJoin('warehouses', 'boths.house_id', '=', 'warehouses.id')
     ->where('boths.user_id', $id)
     ->selectRaw('
         MAX(boths.id) as id,
         boths.house_id,
         boths.productName,
         boths.barCode,
         MAX(boths.creator) as creator,
         MAX(boths.purchasePrice) as purchasePrice,
         MAX(boths.salesPrice) as salesPrice,
         MAX(boths.remaining) as remaining,
         (SELECT c2.previous FROM boths AS c2 WHERE c2.productName = boths.productName AND c2.barCode = boths.barCode ORDER BY c2.updated_at DESC LIMIT 1) as previous,
          (SELECT c2.quantity FROM boths AS c2 WHERE c2.productName = boths.productName AND c2.barCode = boths.barCode ORDER BY c2.updated_at DESC LIMIT 1) as quantity,

         SUM(boths.profit) as profit,
         SUM(boths.totalStockOutPrice) as totalStockOutPrice,
         MAX(boths.Transaction) as Transaction,
         MAX(boths.created_at) as created_at,
         MAX(boths.updated_at) as updated_at,
         (SELECT remaining FROM boths AS c3 WHERE c3.productName = boths.productName AND c3.barCode = boths.barCode ORDER BY c3.updated_at DESC LIMIT 1) as remaining
     ')
     ->groupBy('boths.productName', 'boths.barCode', 'boths.house_id')
    ->where(function ($query) use ($search) {
        $query->where('productName', 'LIKE', '%' . $search . '%')
            ->orWhere('barCode', 'LIKE', '%' . $search . '%')
             ->orWhere('Transaction', 'LIKE', '%' . $search . '%');
    })
->when($dateFilter, function ($query, $dateFilter) {
    switch($dateFilter){
        case 'today':
            $query->whereDate('boths.created_at',Carbon::today());
            break;
        case 'yesterday':
            $query->whereDate('boths.created_at',Carbon::yesterday());
            break;
        case 'this_week':
            $query->whereBetween('boths.created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
            break;
            case 'january':
                $query->whereMonth('boths.created_at', 1);
                break;
            case 'february':
                $query->whereMonth('boths.created_at', 2);
                break;
            case 'march':
                $query->whereMonth('boths.created_at', 3);
                break;
            case 'april':
                $query->whereMonth('boths.created_at', 4);
                break;
            case 'may':
                $query->whereMonth('boths.created_at', 5);
                break;
            case 'june':
                $query->whereMonth('boths.created_at', 6);
                break;
            case 'july':
                $query->whereMonth('boths.created_at', 7);
                break;
            case 'august':
                $query->whereMonth('boths.created_at', 8);
                break;
            case 'september':
                $query->whereMonth('boths.created_at', 9);
                break;
            case 'october':
                $query->whereMonth('boths.created_at', 10);
                break;
            case 'november':
                $query->whereMonth('boths.created_at', 11);
                break;
            case 'december':
                $query->whereMonth('boths.created_at', 12);
                break;
    }

})
->get();


            $data3 = array_merge($stockInData->toArray(), $cartData->toArray());

        return response()->json([
            'data' => $cartData,

        ]);
    }
}
