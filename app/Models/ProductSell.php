<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSell extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'type','profit','total_sold','total_quantity','totalPrice', 'question', 'sold_count','description', 'data', 'product_id'];

}
