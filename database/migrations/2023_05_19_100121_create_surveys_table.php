<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->foreignIdFor(\App\Models\Category::class, 'category_id');
            $table->string('productName')->nullable();
            $table->longText('barCode')->nullable();
            $table->string('image',255)->nullable();
            $table->longText('purchasePrice')->default(0);
            $table->longText('salesPrice')->default(0);
             $table->longText('quantity')->nullable();
            $table->longText('code')->nullable();
            $table->longText('size')->nullable();
            $table->longText('color')->nullable();
            $table->longText('brand')->nullable();
            $table->tinyInteger('status');
             $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
