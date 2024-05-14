<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsList extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'productName','barCode', 'image','purchasePrice',
    'salesPrice', 'category','quantity', 'code', 'size','status',
   'color', 'brand','status' ];


   public function user()
   {
       return $this->belongsTo(User::class);
   }
}
