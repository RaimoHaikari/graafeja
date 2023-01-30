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

        if(isset($args['departureStationID']) and isset($args['returnStationID'])){

            $returnStationID =  $args['returnStationID'];
            $departureStationID =  $args['departureStationID'];

            $query = <<<END
            SELECT minuteBin, COUNT(*) as lkm
            FROM trips
            WHERE departureStationID = $departureStationID AND returnStationId = $returnStationID
            GROUP BY minuteBin
            ORDER BY minuteBin
          END;

        }
        elseif(isset($args['returnStationID'])){

            $returnStationID =  $args['returnStationID'];

            $query = <<<END
            SELECT minuteBin, COUNT(*) as lkm
            FROM trips
            WHERE returnStationId = $returnStationID
            GROUP BY minuteBin
            ORDER BY minuteBin
          END;
        }
        elseif(isset($args['departureStationID'])){

            $departureStationID =  $args['departureStationID'];

            $query = <<<END
            SELECT minuteBin, COUNT(*) as lkm
            FROM trips
            WHERE departureStationID = $departureStationID
            GROUP BY minuteBin
            ORDER BY minuteBin
          END;

        }
        else {
            $query = <<<END
            SELECT minuteBin, COUNT(*) as lkm
            FROM trips
            GROUP BY minuteBin
            ORDER BY minuteBin
          END;
        }
      
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
