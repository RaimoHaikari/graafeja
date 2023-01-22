<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\EventsByDayOfTheWeek;

/*
 * Kuinka paljon asemalla on palautettu pyoria, ku palautuksia
 * tarkastellaan viikonpäivän mukaan.
 */ 
final class ReturnsByTheDayOfWeek
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = [];

        $returnStationID = $args['returnStationID'];
    
        $query = <<<END
        SELECT ret_weekday, count(*) as lkm
        FROM trips
        WHERE returnStationId = $returnStationID
        GROUP BY ret_weekday
      END;

        $data = DB::select($query);

        foreach ($data as $d) {

            //Log::info((json_encode($d)));

            array_push(
                $val, 
                new EventsByDayOfTheWeek(
                    [
                        'day_of_week' => $d->ret_weekday,
                        'number_of_events' =>  $d->lkm
                    ]
                )
            );
        }

        /*
        foreach ($data as $d) {
            $index = ($d->ret_weekday) - 1;
            $val[$index] = $d->lkm;
        }
        */


        return $val;
    }
}
