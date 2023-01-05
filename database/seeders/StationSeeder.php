<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;


class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tyhjennetään taulu
        Station::truncate();

        $csvFile = fopen("https://raw.githubusercontent.com/RaimoHaikari/tahtisadetta/main/Misc/stationsProd.csv", "r");

        $firstline = true;
        // id,nimi,wiki,imdb,kavi,img,ensiIlta
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $ensiIlta =  explode(".", $data['7']);

                Station::create([
                    "stationID" => $data['1'],
                    "nimi" => $data['2'],
                    "palautuksia" => $data['16'],
                    "lainoja" => $data['13'],
                    "kapasiteetti" => $data['10']
                ]);    
            }
            $firstline = false;

        }

        fclose($csvFile);

    }
}
