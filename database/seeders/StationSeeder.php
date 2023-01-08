<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;


class StationSeeder extends Seeder
{
    /**
     * ID
     * Nimi
     * Namn
     * Name
     * Osoite
     * Adress
     * Kaupunki
     * Stad
     * Kapasiteet
     * x
     * y
     *
     * @return void
     */
    public function run()
    {
        // Tyhjennetään taulu
        Station::truncate();

        // $csvFile = fopen("https://raw.githubusercontent.com/RaimoHaikari/tahtisadetta/main/Misc/stationsProd.csv", "r");
        $csvFile = fopen(base_path("database/data/stationsProd.csv"), "r");

        $firstline = true;
        // id,nimi,wiki,imdb,kavi,img,ensiIlta
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                Station::create([
                    "stationID" => $data['0'],
                    "nimi" => $data['1'],
                    "namn" => $data['2'],
                    "name" => $data['3'],
                    "osoite" => $data['4'],
                    "adress" => $data['5'],
                    "kaupunki" => $data['6'],
                    "stad" => $data['7'],
                    "kapasiteetti" => $data['8'],
                    "x" => $data['9'],
                    "y" => $data['10']
                ]);    
            }
            $firstline = false;

        }

        fclose($csvFile);

    }
}
