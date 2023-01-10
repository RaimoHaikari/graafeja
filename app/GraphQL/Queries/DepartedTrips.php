<?php

namespace App\GraphQL\Queries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\DepartedTrips AS DepartedTripsModel;

final class DepartedTrips
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = array();

        $departureStationID = $args['departureStationID'];

        $query = <<<END
        SELECT departureStationID, returnStationId, count(*) as lkm
        FROM trips
        WHERE departureStationID = $departureStationID
        GROUP BY departureStationID, returnStationId
        ORDER BY lkm DESC
      END;

        $data = DB::select($query);

        
        foreach ($data as $d) {
            array_push(
                $val, 
                new DepartedTripsModel(
                    [
                        'departureStationID' => $d->departureStationID,
                        'returnStationID' => $d->returnStationId,
                        'lkm' =>  $d->lkm
                    ]
                )
            );
        }
        
        
        return $val;
    }
}