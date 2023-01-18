<?php

namespace App\GraphQL\Queries;
use Illuminate\Support\Facades\DB;

use App\Models\TripsByReturnStation  AS TripsByReturnStationModel;
use App\Models\Station;

use Illuminate\Support\Facades\Log;

final class TripsByReturnStation
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val= array();

        if(isset($args['returnStationID'])){

            $returnStationID =  $args['returnStationID'];

            $query = <<<END
            SELECT *
            FROM tripsByReturnStation
            WHERE returnStationId = $returnStationID
          END;

            Log::info($query);
        }
        else {
            $query = <<<END
            SELECT *
            FROM tripsByReturnStation
            ORDER BY lkm DESC
            LIMIT 20
          END;
        }        

        $data = DB::select($query);

        // Haetaan myös asemien nimitiedot
        $stations = Station::all();

        foreach ($data as $d) {

            $returnStation = $stations->where('stationID',  $d->returnStationId)->first();
            //Log::info(json_encode($departureStation));

            array_push(
                $val, 
                new TripsByReturnStationModel(
                    [
                        'returnStationID' => $d->returnStationId,
                        'returnStationName' => $returnStation->nimi,
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
        
        return $val;
    }
}