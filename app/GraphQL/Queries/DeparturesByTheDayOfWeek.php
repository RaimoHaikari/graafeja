<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\EventsByDayOfTheWeek;

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
        $val = [];

        $departureStationID = $args['departureStationID'];
    
        $query = <<<END
        SELECT dep_weekday, count(*) as lkm
        FROM trips
        WHERE departureStationID = $departureStationID
        GROUP BY dep_weekday
      END;

        $data = DB::select($query);

        /* 
        {"dep_weekday":1,"lkm":474}
        */

        foreach ($data as $d) {

            //Log::info((json_encode($d)));

            array_push(
                $val, 
                new EventsByDayOfTheWeek(
                    [
                        'day_of_week' => $d->dep_weekday,
                        'number_of_events' =>  $d->lkm
                    ]
                )
            );
        }
        

        


        return $val;
    }
}
