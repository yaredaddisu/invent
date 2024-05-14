<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Both extends Model
{
    use HasFactory;
        protected $fillable = ['updated','reference','house_id','creator', 'survey_id','salesPrice','Transaction','totalStockOutPrice','purchasePrice','user_id','quantity','previous','productName','profit','barCode','remaining'];


        public function product()
        {
            return $this->belongsTo(Survey::class);
        }
        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function house() {
            return $this->belongsTo(Warehouse::class, 'house_id');
        }

        public function getCreator()
        {
            return $this->user->name;
        }

        public function category() {
            return $this->belongsTo(Category::class, 'category_id');
        }

}
