<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * php artisan db:seed --class=DatabaseSeeder
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StationSeeder::class,
            TripSeeder::class
        ]);
    }

}
