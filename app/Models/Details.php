<?php

namespace App\Models;

use App\Models\Both;
use App\Models\Cart;
use App\Models\TempPrint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details extends Model
{

    protected $fillable = [
        'amount',
        'tax',
        'shipping',
        'discount',
        'TotalQuantity',
        'TotalProduct',
        'Reference',
        'user_id',
        'name',
    'email',
    'phone',
    'address',
    'status',
    'paymentMethod',
    'PayedAmount',
'Tin',
'Vat',
'Note',
'Due'

    ];
    use HasFactory;

    public function questions()
{
    return $this->hasMany(Both::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}
