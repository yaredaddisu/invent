<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->longText('amount')->nullable();
            $table->longText('tax')->nullable();
            $table->longText('shipping')->nullable();
            $table->longText('TotalQuantity')->nullable();
            $table->longText('TotalProduct')->nullable();
            $table->String('Reference');
            $table->String('name')->nullable();
            $table->String('email')->nullable();
            $table->String('phone')->nullable();
            $table->String('address')->nullable();
            $table->String('paymentMethod')->nullable();
            $table->String('Vat')->nullable();
            $table->String('Tin')->nullable();
            $table->longText('Due')->nullable();
            $table->longText('PayedAmount')->nullable();
            $table->longText('Note')->default("Note")->nullable();
            $table->String('status')->default("Completed");
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
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
        Schema::dropIfExists('details');
    }
}
