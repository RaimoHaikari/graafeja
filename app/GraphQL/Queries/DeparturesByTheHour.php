<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/*
 * Kuinka paljon asemalta on lainattu pyöriä, ku lainauksia
 * tarkastellaan lainaustunnin mukaan.
 */ 
final class DeparturesByTheHour
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = array_fill(0, 24, 0);

        $departureStationID = $args['departureStationID'];
    
        $query = <<<END
        SELECT dep_h, count(*) as lkm
        FROM trips
        WHERE departureStationID = $departureStationID
        GROUP BY dep_h
      END;

        $data = DB::select($query);

        //Log::info((json_encode($data)));

        foreach ($data as $d) {
            $index = $d->dep_h;
            $val[$index] = $d->lkm;
        }


        return $val;
    }
}
