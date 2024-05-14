<?php

use \App\Models\Supplier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('dateOfDelivery')->nullable();
            $table->longText('dateOfPurchase')->nullable();
            $table->longText('note')->nullable();
            $table->longText('purchases')->nullable();
            $table->string('slug')->unique()->nullable() ;
            $table->tinyInteger('status');

            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->foreignIdFor(Supplier::class, 'supplier_id');
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
        Schema::dropIfExists('purchases');
    }
}
