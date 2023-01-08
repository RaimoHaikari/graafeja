<?php

namespace App\GraphQL\Queries;
use Illuminate\Support\Facades\DB;
use App\Models\TripsByReturnStation  AS TripsByReturnStationModel;

final class TripsByReturnStation
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
        FROM tripsByReturnStation
      END;

        $data = DB::select($query);

        
        foreach ($data as $d) {
            array_push(
                $val, 
                new TripsByReturnStationModel(
                    [
                        'returnStationID' => $d->returnStationId,
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