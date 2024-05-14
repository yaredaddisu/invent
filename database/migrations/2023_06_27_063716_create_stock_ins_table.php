<?php

use App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id();
            $table->string('productName')->nullable();
            $table->longText('barCode')->nullable();
            $table->longText('purchasePrice')->nullable();
            $table->longText('salesPrice')->nullable();
            $table->longText('remaining')->nullable();
            $table->longText('previous')->nullable();
            $table->longText('quantity')->nullable();
            $table->longText('Transaction')->nullable();
            $table->longText('creator')->nullable();
            $table->longText('reference')->nullable();
            $table->foreignIdFor(Warehouse::class, 'house_id');
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->foreignIdFor(\App\Models\Survey::class, 'survey_id');
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
        Schema::dropIfExists('stock_ins');
    }
}
