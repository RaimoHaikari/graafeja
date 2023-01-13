<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/*
 * Kuinka paljon asemalta on lainattu pyöriä, ku lainauksia
 * tarkastellaan viikonpäivän mukaan.
 */ 
final class DeparturesByTheDayOfWeek
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = array_fill(0, 7, 0);

        $departureStationID = $args['departureStationID'];
    
        $query = <<<END
        SELECT dep_weekday, count(*) as lkm
        FROM trips
        WHERE departureStationID = $departureStationID
        GROUP BY dep_weekday
      END;

        $data = DB::select($query);

        //Log::info((json_encode($data)));

        foreach ($data as $d) {
            $index = ($d->dep_weekday) - 1;
            $val[$index] = $d->lkm;
        }


        return $val;
    }
}
