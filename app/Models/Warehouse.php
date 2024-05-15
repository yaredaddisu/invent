<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = [ 'name',
    'user_id',
    'location',
    'capacity',
    'description', ];

    public function user() {
        return $this->belongsTo(User::class);
    }
 public function purchases() {
        return $this->hasMany(Purchase::class);
    }

  public function carts() {
        return $this->hasMany(Cart::class);
    }
}
