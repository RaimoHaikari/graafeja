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

        if(isset($args['departureStationID']) and isset($args['returnStationID'])){

            $returnStationID =  $args['returnStationID'];
            $departureStationID =  $args['departureStationID'];

            $query = <<<END
            SELECT distBin, COUNT(*) as lkm
            FROM trips
            WHERE departureStationID = $departureStationID AND returnStationId = $returnStationID
            GROUP BY distBin
            ORDER BY distBin ASC
          END;

        }
        elseif(isset($args['departureStationID'])){

            $departureStationID =  $args['departureStationID'];

            $query = <<<END
            SELECT distBin, COUNT(*) as lkm
            FROM trips
            WHERE departureStationID = $departureStationID
            GROUP BY distBin
            ORDER BY distBin ASC
          END;

        }
        elseif(isset($args['returnStationID'])){

            $returnStationID =  $args['returnStationID'];

            $query = <<<END
            SELECT distBin, COUNT(*) as lkm
            FROM trips
            WHERE returnStationId = $returnStationID
            GROUP BY distBin
            ORDER BY distBin ASC
          END;
        }
        else {
            $query = <<<END
            SELECT distBin, COUNT(*) as lkm
            FROM trips
            GROUP BY distBin
            ORDER BY distBin ASC
          END;
        }
    

      
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
