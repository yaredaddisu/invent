<?php

use \App\Models\Details;
use \App\Models\Survey;
use \App\Models\User;
use \App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('productName')->nullable();
            $table->longText('barCode')->nullable();
            $table->longText('purchasePrice')->nullable();
            $table->longText('salesPrice')->nullable();
            $table->longText('remaining')->nullable();
            $table->longText('previous')->nullable();
            $table->longText('quantity')->nullable();
            $table->longText('profit')->nullable();
            $table->longText('creator')->nullable();
            $table->longText('Transaction')->nullable();
            $table->longText('reference')->nullable();

            $table->longText('totalStockOutPrice')->nullable();
            $table->foreignIdFor(User::class, 'user_id');
            $table->foreignIdFor(Details::class, 'details_id');
            $table->foreignIdFor(Survey::class, 'survey_id');
            $table->foreignIdFor(Warehouse::class, 'house_id');
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
        Schema::dropIfExists('carts');
    }
}
