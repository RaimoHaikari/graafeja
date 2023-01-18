<?php

namespace App\GraphQL\Queries;

use App\Models\Station;
use App\Models\TripSummary;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

final class PopularTrips
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = [];

        $query = <<<END
        SELECT departureStationID, returnStationId, COUNT(*) as lkm, AVG(coveredDistance) as coveredDistance, AVG(duration) as duration
        FROM trips
        GROUP BY departureStationID, returnStationId
        ORDER BY lkm DESC
        LIMIT 20
      END;

        $data = DB::select($query);

        // Haetaan myös asemien nimitiedot
        $stations = Station::all();

        Log::info(json_encode($data)); 
        
        
        foreach ($data as $d) {

            $depatureStation = $stations->where('stationID',   $d->departureStationID)->first();

            $returnStation = $stations->where('stationID',  $d->returnStationId)->first();
            //Log::info(json_encode($departureStation));

            array_push(
                $val, 
                new TripSummary(
                    [
                        'departureStationID' => $d->departureStationID,
                        'departureStationName' => $depatureStation->nimi,
                        'returnStationId' => $d->returnStationId,
                        'returnStationName' => $returnStation->nimi,
                        'lkm' =>  $d->lkm,
                        'avgDistance' => $d->coveredDistance,
                        'avgDuration' => $d->duration,
                    ]
                )
            );
        }
        

        return $val;
    }
}
