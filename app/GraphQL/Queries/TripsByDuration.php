<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use App\Models\DurationBin;

final class TripsByDuration
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = [];
    
        $query = <<<END
        SELECT minuteBin, COUNT(*) as lkm
        FROM trips
        GROUP BY minuteBin
        ORDER BY minuteBin
      END;
      
        $data = DB::select($query);


        foreach ($data as $d) {
            array_push(
                $val,
                new DurationBin([
                    'bin' => $d->minuteBin,
                    'number_of_events' => $d->lkm               
                ])
            );
        }

        return $val;
    }
}
