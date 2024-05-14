<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\LogoRequest;
use App\Http\Resources\LogoResource;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UpdateLogoRequest;

class LogoController extends Controller
{


    public function index(Request $request)
    {
        $user = $request->user();

        $data = Logo::select("*")
         ->where('user_id', $user->id)
         ->orderBy( "updated_at", 'desc')
         ->paginate(10000000);

        return LogoResource::collection($data);

     }


     public function getLogo(Request $request)
     {
        $user = $request->user();

        $data = Logo::select("*")
         ->where('user_id', $user->id)
         ->where('status', 1)
         ->latest('id')->limit(1)->get();

        return LogoResource::collection($data);

        }

    public function store(LogoRequest $request)
    {
        $data = $request->validated();

        // Check if image was given and save on local file system
        if (isset($data['image'])) {
            $relativePath  = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }


        $logo = Logo::create($data);



        return new LogoResource($logo);
    }

    public function show(Logo $logo, Request $request)
    {


        return new LogoResource($logo);
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

        $dir = 'images/logos';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }

    public function update(UpdateLogoRequest $request, Logo $logo)
    {
         $data = $request->validated();


        // Check if image was given and save on local file system
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;

            // If there is an old image, delete it
            if ($logo->image) {
                $absolutePath = public_path($logo->image);
                File::delete($absolutePath);
            }
        }

        // Update logo in the database
        $logo->update($data);


        return new LogoResource($logo);
    }
 public function destroy(Logo $logo, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $logo->user_id) {
            return abort(403, 'Unauthorized action.');
        }

        $logo->delete();



        return response('', 204);
    }

    public function deleteAll(Request $request)
    {


 $id = $request->data;
 foreach($id as $user){
    Logo::where('id',$user)->delete();

 }

         return response()->noContent();


    }
}
