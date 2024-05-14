<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = request('per_page', 10000000000);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');



        $data =  Supplier::query()
        ->where('user_id', $user->id)
        ->where(function($query) use ($search){
            $query->where('fullname', 'LIKE', '%'.$search.'%')
                   ->orWhere('email', 'LIKE', '%'.$search.'%')
                  ->orWhere('address', 'LIKE', '%'.$search.'%');

        })
         ->orderBy("suppliers.".$sortField, $sortDirection)
        ->paginate($perPage);

        return SupplierResource::collection($data);

     }
    public function store(SupplierRequest $request)
    {
        $data = $request->validated();


        $member = Supplier::create($data);

        return response()->json([
            'message'=>'Supplier Created Successfully!!',
            //'member'=>new SupplierResource($member)
        ]);
      }

      public function show(Supplier $member )
      {

          return new SupplierResource($member);
        }

        public function update(UpdateSupplierRequest $request, Supplier $member)
        {
            $data = $request->validated();

             $member->update($data);

             return response()->json([
                'message'=>'Supplier Updated Successfully!!',
                //'member'=>new SupplierResource($member)
            ]);        }

            public function destroy(Supplier $member, Request $request)
            {
                $user = $request->user();
                if ($user->id !== $member->user_id) {
                    return abort(403, 'Unauthorized action.');
                }

                $member->delete();


                return response()->json([
                    'message'=>'Supplier was successfully deleted!',
                    //'member'=>new SupplierResource($member)
                ],200);
             }


                public function deleteAllMember(Request $request)
                {

            $id = $request->data;
            foreach($id as $member){
               Supplier::where('id',$member)->delete();

            }

                    return response()->json([
                        'message'=>"Supplier wes successfully deleted"
                    ]);



               }

}
