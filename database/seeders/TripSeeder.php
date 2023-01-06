<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tyhjennetään taulu
        Trip::truncate();

        $csvFile = fopen(base_path("database/data/2021-05-Prod.csv"), "r");
        //$csvFile = fopen("http://city-bike-app.tahtisadetta.fi/data/2021-05-Prod.csv", "r");

        $firstline = true;
        // id,nimi,wiki,imdb,kavi,img,ensiIlta
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                Trip::create([
                    "departureStationID" => $data['0'],
                    "returnStationId" => $data['1'],
                    "coveredDistance" => $data['2'],
                    "duration" => $data['3']
                ]);    
            }
            $firstline = false;

        }

        fclose($csvFile);
    }
}
