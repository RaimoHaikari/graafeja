<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripSeeder extends Seeder
{

    /*
     * departureStationID
     * returnStationId
     * coveredDistance
     * duration
     * 
     * php artisan db:seed --class=DatabaseSeeder
     */
    public function run() {
        // Tyhjennetään taulu
        Trip::truncate();

        $csvFile = fopen(base_path("database/data/2021-05-Prod.csv"), "r");
        $firstline = true;

        $temp_count = 0;
        $values = [];

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $temp_count++;

                /*
                 * departureStationId
                 * returnStationId
                 * coveredDistance
                 * duration
                 * dep_H
                 * dep_M
                 * dep_Day
                 * dep_Weekday
                 * dep_Month
                 * dep_Year
                 * ret_H
                 * ret_M
                 * ret_Day
                 * ret_Weekday
                 * ret_Month
                 * ret_Year
                 */
                array_push(
                    $values,
                    [
                        "departureStationID" => $data['0'],
                        "returnStationId" => $data['1'],
                        "coveredDistance" => $data['2'],
                        "duration" => $data['3'],
                        "dep_H" => $data['4'],
                        "dep_M" => $data['5'],
                        "dep_Day" => $data['6'],
                        "dep_Weekday" => $data['7'],
                        "dep_Month" => $data['8'],
                        "dep_Year" => $data['9'],
                        "ret_H" => $data['10'],
                        "ret_M" => $data['11'],
                        "ret_Day" => $data['12'],
                        "ret_Weekday" => $data['13'],
                        "ret_Month" => $data['14'],
                        "ret_Year" => $data['15'],
                        "distBin" => $data['16'],
                        "minuteBin" => $data['17'],
                    ]
                );

                if ($temp_count % 100 == 0) {

                    Trip::insert($values);

                    $values = [];
                }

   
            }
            $firstline = false;

        }

        if(count($values) > 0) {
            Trip::insert($values);
        }

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function fun()
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
