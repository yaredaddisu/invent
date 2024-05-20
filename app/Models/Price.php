<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'price','plan' ];
    public function user()
    {
           return $this->belongsTo(User::class);
    }

}
