<?php

namespace App\Http\Controllers;

use \DateTime;
use App\Exports\userExport;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\StoreuserRequest;
use App\Http\Requests\UpdateManagmentRequest;
use App\Http\Requests\UpdateuserRequest;
use App\Http\Requests\UserManagmentRequest;
use App\Http\Requests\userOrder;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserManagmentResource;
use App\Http\Resources\userOrderResource;
use App\Http\Resources\userResource;
use App\Mail\OrderCreateEmail;
use App\Mail\OrderUpdateEmail;
use App\Models\Order;
use App\Models\Plan;
use App\Models\PlanQuestion;
use App\Models\Price;
use App\Models\User;
use App\Models\userOrderPrice;
use App\Notifications\PaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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



   if ($user->is_super_admin) {
    $data = User::query( )
    ->where(function($query) use ($search){
        $query->where('name', 'LIKE', '%'.$search.'%')
               ->orWhere('email', 'LIKE', '%'.$search.'%')
               ->orWhere('phone', 'LIKE', '%'.$search.'%')
               ->orWhere('id', 'LIKE', '%'.$search.'%');



    })
     ->orderBy($sortField, $sortDirection)
    ->paginate($perPage);
    return UserManagmentResource::collection($data);


  } else if($user->is_admin) {
    $data = User::query( )
        ->where('is_super_admin', 0)
       ->where(function($query) use ($search){
           $query->where('name', 'LIKE', '%'.$search.'%')
                  ->orWhere('email', 'LIKE', '%'.$search.'%')
                  ->orWhere('phone', 'LIKE', '%'.$search.'%')
                  ->orWhere('id', 'LIKE', '%'.$search.'%');



       })
        ->orderBy($sortField, $sortDirection)
       ->paginate($perPage);
       return UserManagmentResource::collection($data);
  }else{
    return response()->json("unauthorized action", 400);
  }

}






     public function activeUsers(Request $request)
     {
         $user = $request->user();

         return User::where('status', 1)->count();
     }

  public function InactiveUsers(Request $request)
     {
         $user = $request->user();

         return User::where('status', 0)->count();
     }


    /**
     *
     * Store a newly created resource in storage.
     *
     *
     * @param  \App\Http\Requests\StoreuserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserManagmentRequest $request)
    {

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        // Check if image was given and save on local file system
        if (isset($data['image'])) {
            $relativePath  = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }


        $user = User::create($data);

        return new UserManagmentResource($user);
    }
 private function saveImage($image)
    {
        // Check if image is valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without mime type
            $image = substr($image, strpos($image, ',') + 1);
            // Get file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $dir = 'images/users';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
     public function show($id, Request $request)
    {

        $user = $request->user();


        $user = User::find($id);

        return new UserManagmentResource($user);
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateuserRequest  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */

    public function update($id, UpdateManagmentRequest $request)
    {


        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user = User::find($id);

        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;

            // If there is an old image, delete it
            if ($user->image) {
                $absolutePath = public_path($user->image);
                File::delete($absolutePath);
            }
        }
        $user->update($data);


           return new UserManagmentResource($user);
        }

        private function updateQuestion(Plan $plan, $data)
        {

            $validator = Validator::make($data, [
           //'id' => 'exists:App\Models\Planplan,id',
           'id' => 'exists:App\Models\Plan,id',
           'status' => 'required|boolean',
           'price'=>' numeric',


            ]);

            if( $data['status'] )
            {
                $price =  $data['price'];
                $plan->user->notify(new PaymentNotification($plan, $price));

            }



            return $plan->update($validator->validated());
        }

        public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }





public function updateDate  (Request $request )
{
    $member = User::findOrFail($request->id);

    if (!$member) {
        return response()->json(['error' => 'Member not found'], 404);
    }

       // Retrieve today's date
       $today = new DateTime();

       // Retrieve the existing day_left value
       $existingDayLeft = new \DateTime($member->day_left);

       // If day_left is less than today's date, set it to today's date
       if ($existingDayLeft < $today) {
           $existingDayLeft = $today;
       }

       // Add the add_days value to the existing day_left value
       $existingDayLeft->modify('+' . $request->add_days . ' days');

       // Format the new day_left value
       $newDayLeft = $existingDayLeft->format('Y-m-d');

       // Update the day_left field of the Member model
       $member->day_left = $newDayLeft;
       // Update other fields as needed

       $member->save();
       if($request->price != 0){
        $price = new Price();
        $price->user_id = $member->id;
        $price->price = $request->price;
        $price->plan = $request->plan;

        $price->save();
       }


       return response()->json(['message' => 'Member updated successfully'], 200);
   }



}
