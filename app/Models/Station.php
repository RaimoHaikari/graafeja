<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TripsByDepartureStation;

use Illuminate\Support\Facades\DB;

class Station extends Model
{
    /*
     */
    protected $fillable = [
        'stationID', 
        'nimi', 
        'namn', 
        'name', 
        'osoite',
        'adress', 
        'kaupunki', 
        'stad', 
        'kapasiteetti', 
        'x',
        'y',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['tripsByDepartureStation'];

    /**
     * Determine if the user is an administrator.
     *
     * @return App\Models\TripsByDepartureStation
     */
    protected function getTripsByDepartureStationAttribute(): array
    {
        $val = array();

        $departureStationID = $this->attributes['stationID'];


        $query = <<<END
        SELECT *
        FROM tripsbydeparturestation
        WHERE departureStationID = $departureStationID
      END;

        /*

        $data = DB::select($query);


        foreach ($data as $d) {
            array_push(
                $val, 
                new TripsByDepartureStation(
                    [
                        'departureStationID' => $d->departureStationID,
                        'lkm' =>  $d->lkm,
                        'maxDistance' => $d->maxDistance,
                        'avgDistance' => $d->avgDistance,
                        'minDistance' => $d->minDistance,
                        'maxDuration' =>  $d->maxDuration,
                        'avgDuration' => $d->avgDuration,
                        'minDuration' => $d->minDuration,
                    ]
                )
            );
        }
        */

        return $val;
    }

    public function debugger($txt) {
        //$myfile = fopen(base_path("storage/logs/debugger.txt"), "wr") or die("Unable to open file!");
        // fwrite($myfile, $txt);
        $myfile = file_put_contents(
            base_path("storage/logs/debugger.txt"), 
            $txt.PHP_EOL , 
            FILE_APPEND | LOCK_EX
        );
        //fclose($myfile);
    }
}
