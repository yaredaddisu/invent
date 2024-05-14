<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class perController extends Controller
{
    public function deleteAllProduct(Request $request)
    {



 $id = $request->data;
 foreach($id as $member){
    Purchase::where('id',$member)->delete();

 }
}
}
