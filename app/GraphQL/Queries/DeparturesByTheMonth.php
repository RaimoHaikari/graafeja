<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\EventsByMonth;

final class DeparturesByTheMonth
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = [];

        $departureStationID = $args['departureStationID'];
    
        $query = <<<END
        SELECT dep_month, COUNT(*) as lkm
        FROM trips
        WHERE departureStationID = $departureStationID
        GROUP BY dep_month
        ORDER BY dep_month
      END;

        $data = DB::select($query);


        foreach ($data as $d) {
            array_push(
                $val,
                new EventsByMonth([
                    'month' => $d->dep_month,
                    'number_of_events' => $d->lkm               
                ])
            );
        }

        return $val;
    }
}
