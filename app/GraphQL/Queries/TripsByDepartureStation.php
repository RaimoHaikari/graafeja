<?php

namespace App\GraphQL\Queries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TripsByDepartureStation  AS TripsByDepartureStationModel;

/*
 * Mikäli lainausaseman id-tunnus on määritetty, palautetaan
 * yhteenveto kyseiseltä asemalta suoritetuista lainauksista.
 * 
 * Mikäli em. parametriä ei ole asetettu, palautetaan yhteenvedot
 * kaikilta asemilta.
 */
final class TripsByDepartureStation
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val= array();

        if(isset($args['departureStationID'])){

            $departureStationID =  $args['departureStationID'];

            $query = <<<END
            SELECT *
            FROM tripsByDepartureStation
            WHERE departureStationID = $departureStationID
          END;
        }
        else {
            $query = <<<END
            SELECT *
            FROM tripsByDepartureStation
          END;
        }

        $data = DB::select($query);

        
        foreach ($data as $d) {
            array_push(
                $val, 
                new TripsByDepartureStationModel(
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
        
        return $val;
    }
}