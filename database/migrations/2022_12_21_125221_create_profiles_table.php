<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->foreignIdFor(\App\Models\User::class, 'user_id')->onDelete('cascade')->onUpdate('cascade');
             $table->string('image', 255)->default(null)->nullable();
             $table->string('company')->default("Company Name");
             $table->string('address')->default("Ethiopia");
             $table->String('Vat')->nullable(); 
             $table->String('Tin')->nullable(); 
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
        Schema::dropIfExists('profiles');
    }
}
