<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\MemberExport;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\MemberResource;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

class  UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if ( Auth::user()->is_admin !==1) {
            return abort(403, 'Unauthorized action.');
        }
        $query = User::query()
            ->where('id', $user->id);
        return UserResource::collection($query);

     }

     public function destroy(User $user)
     {
       
         if ( Auth::user()->is_admin !==1) {
            return abort(403, 'Unauthorized action.');
        }

         $user->delete();
 
         return response()->noContent();
     }
    
     public function deleteAllUser(Request $request)
     {
         
          
 $id = $request->data;
 foreach($id as $user){
    User::where('id',$user)->delete();

 } 
 
         return response()->noContent();
 
 
     
    }


    public function getUserdetails($id)
{
    $userpost = DB::table('users')->where('id', $id)->get();
        
    return response()->json(['data' => $userpost]);
}
}
