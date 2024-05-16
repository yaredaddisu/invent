<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $dateFilter = $request->keyword;

        $query = Survey::with(['category', 'stockOut' => function ($query) use ($dateFilter) {
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
            // Filter only stock out transactions
            $query->where('Transaction', 'Stock Out');
            // Order the 'stockOut' relationship by 'created_at' in descending order
            $query->orderBy('created_at', 'DESC');
        }])
        ->where('user_id', $user->id)
        ->orderBy('updated_at', 'DESC')
        ->get();

        return response()->json($query);


    }

    public function filterByMonth(Request $request)
    {
        $user = $request->user();
        $month = $request->month;

        // Perform filtering
        $query = Survey::with(['category', 'stockOut'])
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

        // Filter only stock out transactions
        $query->whereHas('stockOut', function ($query) {
            $query->where('Transaction', 'Stock Out');
        });

        // Order the 'stockOut' relationship by 'created_at' in descending order
        $query->with(['stockOut' => function ($query) {
            $query->orderBy('created_at', 'DESC');
        }]);

        $data = $query->orderBy('updated_at', 'DESC')->get();
        return response()->json($data);

    }

}
