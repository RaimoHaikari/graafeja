<?php

namespace App\GraphQL\Queries;

use App\Models\Station;
use App\Models\TripSummary;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


/*
# ASEMIEN KESKINÄISET MATKAT
1)
SELECT departureStationID
FROM tripsByDepartureStation
ORDER BY lkm DESC
LIMIT 10

2)
SELECT t.departureStationID, t.returnStationId, COUNT(*) as lkm
FROM
(
	SELECT departureStationID, returnStationId
	FROM trips
	WHERE departureStationID IN (30,126,113,41,21,26,44,22,19,6)
) AS t
WHERE t.returnStationId IN (30,126,113,41,21,26,44,22,19,6)
GROUP BY t.departureStationID, t.returnStationId
*/
final class PopularTrips
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // Haetaan kiireisimmät lainausasemat
        $topArr = $this->getTopDepatureStations();
        $ids = implode(',', $topArr);
  
        $val = [];



        $query = <<<END
        SELECT t.departureStationID, t.returnStationId, COUNT(*) as lkm
        FROM
        (
            SELECT departureStationID, returnStationId
            FROM trips
            WHERE departureStationID IN ($ids)
        ) AS t
        WHERE t.returnStationId IN ($ids)
        GROUP BY t.departureStationID, t.returnStationId
      END;


        $data = DB::select($query);

        // Haetaan myös asemien nimitiedot
        $stations = Station::all();

        //Log::info(json_encode($data)); 
        
        
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
                        'lkm' =>  $d->lkm
                    ]
                )
            );
        }
        
        

        return $val;
    }

    /*
     * Haetaan 10 asemaan,  joista on suoritetty eniten lainauksia
     */
    protected function getTopDepatureStations() {
        $val = [];

        $query = <<<END
        SELECT departureStationID
        FROM tripsByDepartureStation
        ORDER BY lkm DESC
        LIMIT 10
      END;

        $data = DB::select($query);

        foreach ($data as $d) {
            array_push($val, $d->departureStationID);
        }

        return $val;
    }
}
