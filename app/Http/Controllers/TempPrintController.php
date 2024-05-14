<?php

namespace App\Http\Controllers;

use App\Models\Details;
use App\Models\TempPrint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\DetailsResource;

class TempPrintController extends Controller
{

    public function index(Request $request)
    {

        $user = $request->user();




        $data =  Details::where('user_id',$user->id)->orderBy('id', 'desc')->limit(1)->get(); // the most recent entry


        return DetailsResource::collection($data);

     }
    public function store(Request $request)
    {
       $data =  $request->validate([
            'user_id' => ['required'],
            'survey_id' => ['required'],
            'quantity' => ['required'],
            'productName' => ['required', 'string'],
            'salesPrice' => '',

        ]);

        $survey = TempPrint::create($data);


            return response()->json('');


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Details $survey, Request $request)
    {


        return new DetailsResource($survey);
    }

    public function delete(Request $request)
    {


        foreach($request->data as $id){

            Details::whereIn('id', $id)->delete();


               }


               return response('', 204);
       ;
    }

}
