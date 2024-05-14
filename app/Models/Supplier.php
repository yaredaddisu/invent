<?php

namespace App\Models;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'fullname','address', 'email','phone','note'  ];



 public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function user()
    {
           return $this->belongsTo(User::class);
    }
}
