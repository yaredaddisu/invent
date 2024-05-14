<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecretWord extends Model
{
    protected $table = 'secret_words';
public $timestamps = false;
    use HasFactory;
}
