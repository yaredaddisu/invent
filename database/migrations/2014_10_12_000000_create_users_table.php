<?php

use \App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image', 255)->default(null)->nullable();
            $table->string('email')->unique();
             $table->string('company')->default("Company Name");
            $table->string('address')->default("Ethiopia");
            $table->String('Vat')->nullable();
            $table->String('Tin')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('secret')->default(bcrypt(1234));
            $table->string('organization');

            $table->rememberToken();
            $table->foreignIdFor(Warehouse::class, 'house_id')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->date("day_left");

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
        Schema::dropIfExists('users');
    }
}
