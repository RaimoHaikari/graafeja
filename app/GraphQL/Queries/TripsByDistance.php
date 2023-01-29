<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use App\Models\DistanceBin as DistanceBinModel;

final class TripsByDistance
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = [];
    
        $query = <<<END
        SELECT distBin, COUNT(*) as lkm
        FROM trips
        GROUP BY distBin
        ORDER BY distBin ASC
      END;
      
        $data = DB::select($query);


        foreach ($data as $d) {
            array_push(
                $val,
                new DistanceBinModel([
                    'bin' => $d->distBin,
                    'number_of_events' => $d->lkm               
                ])
            );
        }

        return $val;

    }
}
