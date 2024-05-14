<?php

namespace App\Http\Controllers;

use Auth;
use App\Profile;
use App\Models\User;
use Illuminate\Support\Str;
 use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
 use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{


 

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $request->validate([
            'password_current' => 'required',
            'password' => 'required|confirmed',
            
        ]);


        #Match The Old Password
        if(!Hash::check($request->password_current, $user->password)){
            
            return response()->json(['error'=>'Password Not match']);
        }else{
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->password)
            ]);
            return response()->json(['success'=>'Password updated successfully']);

           }

     
    }
    public function updateProfile(Request $request){

        $user = $request->user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'phone', 'max:255', 'unique:users,phone,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'secret' => ['nullable nullable', 'string', 'max:255'],
            'company' => ['nullable ', 'string', 'max:255'],
            'address' => ['nullable ', 'string', 'max:255'],
            'Vat' => ['nullable ',   'max:255'],
            'Tin' => [  'nullable ', 'max:255'],
        ]);
        $user = $user->update($request->except(['_token']));
        if ($user) {
            return response()->json(['success'=>'Profile updated successfully']);
        } else {
            return response()->json(['error'=>'Profile Not updated successfully']);
        }
     }

     public function update(UserRequest $request, User $user ){
       
        $user = $request->user();
        $data = $request->validated();

        if(!Hash::check($data['UserSecret'] , $user->secret)){
            return response([
                'error' => 'Secret Word  is incorrect'
            ], 423);
        }else{
            if (isset($data['secret'])) {
               if($data['secret'] == null){
                $data['secret'] = $user->secret;
               }else{
                $data['secret'] = Hash::make($data['secret']) ;
               }

            }



        }
        
/*
       
        $user = User::find($user->id);
 
if($user->profile){

    
//$user->name = "Alen";
//$user->profile->image = $data['image'];
//$user->profile->secret = $data['secret'];
$user->profile->Vat = $data['Vat'];
$user->profile->Tin = $data['Tin'];
$user->profile->company = $data['company'];
$user->profile->address = $data['address'];
$user->push();
  

}else{
    $comment = $user->profile()->create([
        //'image' => $data['image'],
        //'secret' => $data['secret'],
        'Vat' => $data['address'],
        'Tin' => $data['Tin'],
        'address' => $data['address'],
        'company' => $data['company'],
    ]);
}

       */
      
 
      
        // Check if image was given and save on local file system
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

        return response()->json(['success'=>'Profile updated successfully']);

        // Update user in the database
 


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
 
         $dir = 'images/';
         $file = Str::random() . '.' . $type;
         $absolutePath = public_path($dir);
         $relativePath = $dir . $file;
         if (!File::exists($absolutePath)) {
             File::makeDirectory($absolutePath, 0755, true);
         }
         file_put_contents($relativePath, $image);
 
         return $relativePath;
     }
}
