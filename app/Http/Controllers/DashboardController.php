<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Member;
use ReflectionProperty;
use App\Traits\ReportTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ProductQuestion;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Resources\MemberDashboardResource;

class DashboardController extends Controller
{

     use ReportTrait;

     public function index(){

     }

    public function activeCustomers(Request $request)
    {
        $user = $request->user();

        return Member::where('status', 1)->where('user_id',$user->id)->count();
    }

    public function totalUser()
    {

        return User::count();
    }

    public function inactiveCustomers(Request $request)
    {
        $user = $request->user();

        return Member::where('status', 0)->where('user_id',$user->id)->count();
    }

    public  function today(Request $request){
        $user = $request->user();

        $todayIncome = DB::table('members')
        ->where('user_id', $user->id)
        ->whereYear('updated_at', Carbon::now()->year)
        ->whereMonth('updated_at', Carbon::now()->month)
        ->whereDay('updated_at', Carbon::now()->day)
        ->sum('price');

        $todayMembers  = DB::table('members')
        ->where('user_id', $user->id)
        ->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereDay('created_at', Carbon::now()->day)->count();


        return[
            'todayIncome'=>$todayIncome,
            'todayMembers'=>$todayMembers,

        ];


    }
    public  function todayUser(Request $request){
        $user = $request->user();

        $todayIncome = DB::table('plans')
        ->where('status',1)
        //->join('plan_questions', 'plan_questions.plan_id', '=', 'plans.id')
        ->whereYear('updated_at', Carbon::now()->year)
        ->whereMonth('updated_at', Carbon::now()->month)
        ->whereDay('updated_at', Carbon::now()->day)
        ->sum('price');

        $todayUsers  = DB::table('users')
        ->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereDay('created_at', Carbon::now()->day)->count();


        return[
            'todayIncome'=>$todayIncome,
            'todayUsers'=>$todayUsers,

        ];


    }
    public  function month(Request $request){
        $user = $request->user();

        $monthIncome  = DB::table('members')
        ->where('user_id', $user->id)
        ->whereYear('updated_at', Carbon::now()->year)
        ->whereMonth('updated_at', Carbon::now()->month)
       ->sum('price');

        $monthMembers = DB::table('members')
        ->where('user_id', $user->id)
        ->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)->count();


        return[
            'monthIncome'=>$monthIncome,
            'monthMembers'=>$monthMembers,

        ];
    }
    public  function monthUser(Request $request){
        $user = $request->user();

        $monthIncome  = DB::table('plans')

         ->where('status',1)
         ->whereYear('updated_at', Carbon::now()->year)
        ->whereMonth('updated_at', Carbon::now()->month)
        ->sum('price');

        $monthUsers = DB::table('users')
         ->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)->count();


        return[
            'monthIncome'=>$monthIncome,
            'monthUsers'=>$monthUsers,

        ];
    }


    public function expired(){
        $user = Auth::user();
        $date1 = Carbon::now()->toDateString();
         $date2 = Carbon::parse($user["day_left"])->format('Y-m-d');


        if (($date2 <= $date1) && ($user->is_admin !== 1) && ($user->is_super_admin !== 1) ) {
             return response([
                'message' => 'Your date Expired'
            ], 403);

        }
    }
    public function year(Request $request){
        $user = $request->user();


        $yearIncome = DB::table('members')
        ->where('user_id', $user->id)
        ->whereYear('updated_at', Carbon::now()->year)
        ->sum('price');

        $yearMembers = DB::table('members')
        ->where('user_id', $user->id)
        ->whereYear('created_at', Carbon::now()->year)->count();

        return[
            'yearMembers'=>$yearMembers,
            'yearIncome'=>$yearIncome,

        ];


    }
    public function UserYear(Request $request){
        $user = $request->user();


        $yearIncome = DB::table('plans')
         ->where('status',1)
          ->whereYear('updated_at', Carbon::now()->year)
         ->sum('price');

        $yearUsers = DB::table('users')
         ->whereYear('created_at', Carbon::now()->year)->count();

        return[
            'yearUsers'=>$yearUsers,
            'yearIncome'=>$yearIncome,

        ];


    }
    public function totalIncome(Request $request)
    {
        $user = $request->user();

        $fromDate = $this->getFromDate();
        $query = Member::query()->where('user_id', $user->id);

        if ($fromDate) {
            $query->where('updated_at', '>', $fromDate);
        }
        $totalIncome =  round($query->sum('price'));



      return  $totalIncome;



    }
    public function totalPriceIncome(Request $request)
    {
        $user = $request->user();
        $totalIncome = DB::table('plans')
        ->where('status',1)
        ->sum('price');


       // $totalIncome =  round($query->sum('price'));



      return  $totalIncome;



    }

    public function topMembers(Request $request){
        $user = $request->user();

        $query = Member::query()
                ->where('user_id', $user->id)
                ->where('status', 1)
                 ->orderByRaw('CAST(price AS UNSIGNED) desc')
                ->limit(5)
                ->get();



                return MemberDashboardResource::collection($query);
    }
    public function yearProduct(Request $request){
        $user = $request->user();
        $query = ProductQuestion::query()->where('user_id', $user->id);
        if ($user) {
            $query->join('products', 'product_questions.product_id', '=', 'products.id')
            ->where('products.user_id', $user->id);
        }
         $totalPrice =  round($query->sum('totalPrice'));
         $totalSold =  round($query->sum('total_sold'));
         $profit =  round($query->sum('profit'));

      return  [
      'totalPrice'=>$totalPrice,
      'totalSold'=>$totalSold,
      'profit'=>$profit,
      ];


    }
    public function yearProductCount(Request $request){
        $user = $request->user();
        $query = ProductQuestion::query()->where('user_id', $user->id);
        if ($user) {
            $query->join('products', 'product_questions.product_id', '=', 'products.id')
            ->where('products.user_id', $user->id);
        }
         $total_quantity =  round($query->sum('total_quantity'));
         $sold_count =  round($query->sum('sold_count'));
         $remaining = round($query->sum('total_quantity')) - round($query->sum('sold_count'));
      return  [
      'total_quantity'=>$total_quantity,
      'sold_count'=>$sold_count,
      'remaining'=>$remaining
       ];


    }

     public function latestMembers(Request $request){
        $user = $request->user();

        $query = Member::query()
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get();


                return MemberDashboardResource::collection($query);
    }







}
