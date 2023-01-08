<?php

namespace App\GraphQL\Queries;
use Illuminate\Support\Facades\DB;
use App\Models\TripsByDepartureStation  AS TripsByDepartureStationModel;

final class TripsByDepartureStation
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val= array();

        $query = <<<END
        SELECT *
        FROM tripsByDepartureStation
      END;

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