<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Help;
use App\Models\Logo;
use App\Models\Plan;
use App\Models\Price;
use App\Models\Product;
use App\Models\ProductList;
use App\Models\ProductQuestion;
use App\Models\ProductsList;
use App\Models\Purchase;
use App\Models\StockIn;
use App\Models\Supplier;
use App\Models\Survey;
use App\Models\UserPayment;
use App\Models\Warehouse;
use App\Models\Work;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $dates = ['created_at', 'updated_at', 'day_left'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'secret',
        'image',
        'is_admin',
        'is_super_admin',
        'status',
        'phone',
        'company',
        'address',
        'organization',
        'day_left',
         'Vat',
        'Tin'

    ];



    public function houses() {
        return $this->hasMany(Warehouse::class );
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

     public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }


    public function productList()
    {
        return $this->hasMany(ProductsList::class);
    }


     public function logos()
    {
        return $this->hasMany(Logo::class);
    }
 public function stockin()
    {
        return $this->hasMany(StockIn::class);
    }
   public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
