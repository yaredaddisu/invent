<?php

namespace App\Models;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockIn extends Model
{

    protected $fillable = [ 'reference','house_id','creator', 'survey_id' ,'user_id','salesPrice','purchasePrice','quantity','previous','Transaction','productName','barCode','remaining'];

    public function product()
    {
        return $this->belongsTo(Survey::class);
    }

    public function house() {
        return $this->belongsTo(Warehouse::class, 'house_id');
    }

    public function getCreator()
    {
        return $this->user->name;
    }

    use HasFactory;
}
