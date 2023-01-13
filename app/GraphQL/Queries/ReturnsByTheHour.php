<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/*
 * Kuinka paljon asemalle on palautettu pyöriä, kun palautuksia
 * tarkastellaan palautustunnin mukaan.
 */ 
final class ReturnsByTheHour
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = array_fill(0, 24, 0);

        $returnStationID = $args['returnStationID'];
    
        $query = <<<END
        SELECT ret_h, count(*) as lkm
        FROM trips
        WHERE returnStationId = $returnStationID
        GROUP BY ret_h
      END;

        $data = DB::select($query);

        //Log::info((json_encode($data)));

        
        foreach ($data as $d) {
            $index = $d->ret_h;
            $val[$index] = $d->lkm;
        }
        


        return $val;
    }
}
