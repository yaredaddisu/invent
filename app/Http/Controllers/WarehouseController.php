<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseRequest;
use App\Http\Resources\WarehouseResource;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{


    public function index(Request $request)
    {


        $user = $request->user();

        $perPage = request('per_page', 10000000000);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');



        $data = Warehouse::select("*")
        ->where('user_id', $user->id)
        ->where(function($query) use ($search){
            $query->where('name', 'LIKE', '%'.$search.'%')
                   ->orWhere('location', 'LIKE', '%'.$search.'%')
                   ->orWhere('capacity', 'LIKE', '%'.$search.'%')
;

        })
         ->orderBy($sortField, $sortDirection)
        ->paginate($perPage);


        return WarehouseResource::collection($data);



     }

    public function store(WarehouseRequest $request)
    {
        $data = $request->validated();

        return Warehouse::create($data);
    }

    public function show($id)
    {
        $data =  Warehouse::findOrFail($id);

        return new  WarehouseResource($data);

    }

    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($request->all());

        return $warehouse;
    }

    public function destroy(Warehouse $warehouse, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $warehouse->user_id) {
            return abort(403, 'Unauthorized action.');
        }

        $warehouse->delete();


        return response()->json([
            'message'=>'Warehouse was successfully deleted!',
            //'member'=>new SupplierResource($member)
        ],200);
     }


}
