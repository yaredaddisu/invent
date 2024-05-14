<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryOnceRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = $request->user();
         $categories = Category::withCount(['products' => function ($query)

         {
            $query->withFilters(
                request()->input('prices', []),
                request()->input('categories', []),
                request()->input('manufacturers', [])
            );
        }])
        ->orderBy('updated_at','desc')
        ->where('user_id', $user->id)
        ->get();

    return CategoryResource::collection($categories);

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {


        $data = $request->validated();

        //$data=$request->all();

        $category = Category::create($data);

        return new CategoryResource($category);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Request $request)
    {


            return new CategoryResource($category);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {

        $data = $request->validated();


        $category->update($data);

        return new CategoryResource($category);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {

        $category->delete();

        return response('', 204);
    }


    public function CategoryOnce(CategoryOnceRequest $request)
    {
        $data = $request->validated();

        foreach ($data['categories'] as $question) {
             $this->createQuestion($question);
        }

     }

     private function createQuestion($data)
{


$validator = Validator::make($data, [
            'user_id'=> '',
            'category' => 'required|string|max:1000',



]);

return Category::create($validator->validated());
}
}
