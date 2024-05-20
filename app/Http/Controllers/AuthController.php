<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SecretWord;
use Illuminate\Support\Str;
use App\Models\PasswordRest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\EmailRequest;
use App\Mail\ResetPasswordMailable;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Notifications\ExpiredNotification;
use App\Notifications\DaysLeftNotification;
use App\Notifications\SecretResetNotification;
use App\Notifications\RegisterUserNotification;
use App\Notifications\WelcomeEmailNotification;
use App\Notifications\PasswordResetNotification;

class AuthController extends Controller
{



    public function logout()
    {
        /** @var User $user */
        $user = Auth::user();
        // Revoke the token that was used to authenticate the current request...
        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }



    public function login(Request $request)
    {


        $credentials = $request->validate([
            'email'=> ['required', 'email'],
            'password' => 'required',
            'remember' => 'boolean'
        ]);
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'error' => 'Email or password is incorrect'
            ], 422);
        }


        /** @var \App\Models\User $user */
        $user = Auth::user();
        $date1 = Carbon::now()->toDateString();
         $date2 = Carbon::parse($user["day_left"])->format('Y-m-d');
         $date_left = Carbon::parse($user["day_left"])->diffForHumans();

         $date = Carbon::parse($user->day_left)->subDay(5);

         $newDateTime = "0";

         if ($date->EqualTo($newDateTime)) {

     //$user->notify(new DaysLeftNotification($user, $date_left));



}

if ($date2 <= $date1) {
    // Expire the user's access
    // $user->day_left = null; // or any value that signifies expiration
    // $user->save();

    // Perform any additional actions if needed, such as sending notifications

    // If the user is not an admin or super admin, log them out and return an error
    if (!$user->is_admin && !$user->is_super_admin) {
        Auth::logout();
        return response([
            'error' => 'Your date has expired',
            'id' => $user->id,
        ], 403);
    }
}


  if($user->status == 0) {
            Auth::logout();
            return response([
                'error' => 'Your Account Blocked',
                'id'=>$user->id,
            ], 422);

    }

        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);

    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }

  public function register(AuthRequest $request){

    $data = $request->validated();

 $date = Carbon::parse($request->day_left)->addDays(15);
 $data["day_left"] = $date->format('Y-m-d');

     $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'password' => bcrypt($data['password']),
        'day_left'=> $data["day_left"],
        'organization'=>$data["organization"],
       // 'secret'=> bcrypt($data['secret']),
    ]);
/*
    $profile = $user->profile()->create([
        'Vat' => 'VAT',
        'Tin' => 'TIN',
        'address' => 'Ethiopia',
        'company' => 'Company Name',
    ]);

    */
    $token = $user->createToken('main')->plainTextToken;

   $user->notify(new WelcomeEmailNotification($user));

    return response([
        'user' => $user,
        'token' => $token
    ]);
  }


public function sendToken(EmailRequest $request){
$user = $request->user();

 $user = User::where('email',$request->email)->first();

 if(!isset($user->id)){
    return response([
        'error' => 'User with this email  do not exist'
    ], 422);
  }
//$token = Str::random(32);
$token = $user->createToken('main')->plainTextToken;

  $user->notify(new PasswordResetNotification($token, $user));

 $passwordRest = new PasswordRest();
 $passwordRest->email = $user->email;
 $passwordRest->token = $token;
 $passwordRest->save();
}


public function validateToken(Request $request){
    $passwordRest = PasswordRest::where('token',$request->token)->first();

    if(!isset($passwordRest->email)){
    return response()->json(['error'=>'Invalid token'], 401);
    }

    $user = User::where('email',$passwordRest->email)->first();
    return response()->json($user, 200);
}

public function resetPassword(Request $request){
    $validator = Validator::make($request->all(), [
             'password' => [
                'required',
                'confirmed',
                Password::min(8)
                   // ->mixedCase()
                    ->letters()
                    ->numbers()
                    //->symbols()
                    //->uncompromised(),
            ],
    ]);
    if ($validator->fails()) {
        return response($validator->messages(), 400);
    }

    $user = User::find($request->user_id);
    $passwordRest = PasswordRest::where('email', $user->email)->first();
    $passwordRest->delete();

    $user->password = bcrypt($request->password);
    $user->save();
}


/// reset secret

public function sendResettoken(EmailRequest $request){
$user = $request->user();

 $user = User::where('email',$request->email)->first();

 if(!isset($user->id)){
    return response([
        'error' => 'User with this email  do not exist'
    ], 422);
  }
//$token = Str::random(32);
$token = $user->createToken('main')->plainTextToken;

  $user->notify(new SecretResetNotification($token, $user));

 $passwordRest = new SecretWord();
 $passwordRest->email = $user->email;
 $passwordRest->token = $token;
 $passwordRest->save();
}


public function validateResettoken(Request $request){
    $passwordRest = SecretWord::where('token',$request->token)->first();

    if(!isset($passwordRest->email)){
    return response()->json(['error'=>'Invalid token'], 401);
    }

    $user = User::where('email',$passwordRest->email)->first();
    return response()->json($user, 200);
}

public function resetResettoken(Request $request){
    $validator = Validator::make($request->all(), [
             'secret' => [
                'required',
                'confirmed',
            ],
    ]);
    if ($validator->fails()) {
        return response($validator->messages(), 400);
    }

    $user = User::find($request->user_id);
    $passwordRest = SecretWord::where('email', $user->email)->first();
    $passwordRest->delete();

    $user->secret = bcrypt($request->secret);
    $user->save();
}
}
