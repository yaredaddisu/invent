<?php

namespace Database\Seeders;

use Database\Seeders\WarehouseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(WarehouseSeeder::class);

        $this->call(UserTableSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
