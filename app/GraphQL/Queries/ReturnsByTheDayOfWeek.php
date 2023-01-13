<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $val = array_fill(0, 7, 0);

        $returnStationID = $args['returnStationID'];
    
        $query = <<<END
        SELECT ret_weekday, count(*) as lkm
        FROM trips
        WHERE returnStationId = $returnStationID
        GROUP BY ret_weekday
      END;

        $data = DB::select($query);

        //Log::info((json_encode($data)));

        foreach ($data as $d) {
            $index = ($d->ret_weekday) - 1;
            $val[$index] = $d->lkm;
        }


        return $val;
    }
}
