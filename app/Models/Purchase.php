<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'dateOfDelivery',
    'dateOfPurchase',
    'status',
    'note',
    'purchases',
    'user_id',
    'house_id',
    'supplier_id',];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function house()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function user()
    {
           return $this->belongsTo(User::class);
    }

    // public function getCreator()
    // {
    //     return $this->user->name;
    // }
    public function getSupplier()
{
    return $this->supplier->fullname;
}
//     public function getWarehouseAttribute()
// {
//     return $this->user->house->name;
// }
}
