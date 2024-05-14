<?php

namespace App\Http\Controllers;

use App\Models\Both;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ChartController extends Controller
{
    public function index(Request $request)
{

     $user = $request->user();
        $query = Both::with('category')
        ->where('Transaction','=', 'Stock Out')

        ->where('user_id', $user->id);

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
            case 'last_week':
                $query->whereBetween('created_at',[Carbon::now()->subWeek(),Carbon::now()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at',Carbon::now()->month);
                break;
            case 'last_month':
                $query->whereMonth('created_at',Carbon::now()->subMonth()->month);
                break;
            case 'this_year':
                $query->whereYear('created_at',Carbon::now()->year);
                break;
            case 'last_year':
                $query->whereYear('created_at',Carbon::now()->subYear()->year);
                break;
        }


        $data = $query->orderBy('updated_at',"DESC")->get();



        return response()->json($data);


}

public function filterByMonth(Request $request)
    {
        $user = $request->user();
        $month = $request->month;



        // Perform filtering
        $query = Both::with('category')
        ->where('Transaction','=', 'Stock Out')

            ->where('user_id', $user->id);

        switch(strtolower($month)) {
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

        $data = $query->orderBy('updated_at', 'DESC')->get();

            return response()->json($data);


    }
}
