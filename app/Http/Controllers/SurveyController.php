<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use App\Models\SurveyQuestion;
use Illuminate\Validation\Rule;
use App\Models\SurveyQuestionAnswer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\SurveyResource;
use App\Http\Requests\ProductOnceRequest;
use App\Http\Requests\StoreSurveyRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Requests\StoreSurveyAnswerRequest;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = request('per_page', 10000000000);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');








        $data =  Survey::with(['category'])
        ->where('user_id', $user->id)
        ->where(function($query) use ($search){
            $query->where('productName', 'LIKE', '%'.$search.'%')
                  ->orWhere('barCode', 'LIKE', '%'.$search.'%')
                  ->orWhere('quantity', 'LIKE', '%'.$search.'%')
                      ->orWhereHas('category',function($query) use ($search){
                    $query->where('category','LIKE', '%'.$search.'%');
                });

        })
         ->orderBy($sortField, $sortDirection)
        ->paginate($perPage);

        return SurveyResource::collection($data);

     }


     //$users = \App\Models\User::whereDate('created_at', '<=', now()->subDays(30))->delete();
//dd($users);

    public function store(StoreSurveyRequest $request)
    {
        $data = $request->validated();

        // Check if image was given and save on local file system
        if (isset($data['image'])) {
            $relativePath  = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $survey = Survey::create($data);



        return new SurveyResource($survey);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey, Request $request)
    {


        return new SurveyResource($survey);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */


    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $data = $request->validated();
$user = $request->user();

        // Check if image was given and save on local file system
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;

            // If there is an old image, delete it
            if ($survey->image) {
                $absolutePath = public_path($survey->image);
                File::delete($absolutePath);
            }
        }

        if(!Hash::check($data['UserSecret'] , $user->secret)){
            return response([
                'error' => 'Secret Word  is incorrect'
            ], 423);
        }else{

            $survey->update($data);

        }

        // Update survey in the database


        return new SurveyResource($survey);
    }


    public function destroy(Survey $survey, Request $request)
    {


        $survey->delete();

        // If there is an old image, delete it
        if ($survey->image) {
            $absolutePath = public_path($survey->image);
            File::delete($absolutePath);
        }

        return response('', 204);
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

    public function deleteAllProduct(Request $request)
    {



 $id = $request->data;
 foreach($id as $member){
    Survey::where('id',$member)->delete();

 }




        return response('', 204);


    }

    public function ProductOnce(ProductOnceRequest $request)
    {
        $data = $request->validated();

        foreach ($data['products'] as $question) {
             $this->createQuestion($question);
        }

     }

     private function createQuestion($data)
{


if (isset($data['selected'])) {
    $data['category_id'] =   $data['selected']  ;
}

$validator = Validator::make($data, [
            'user_id'=> '',
            'productName' => 'required|string|max:1000',
            'barCode' => 'required|max:1000',
            'purchasePrice'=>'required',
            'salesPrice' => 'required',
            'category_id' => 'exists:categories,id',
            'quantity' => 'required|numeric',
            'code' => 'nullable|string',
            'size' => 'nullable',
            'color' => 'nullable|string',
            'brand' => ' nullable|string',
            'status' => ' boolean',


]);

return Survey::create($validator->validated());
}
}
