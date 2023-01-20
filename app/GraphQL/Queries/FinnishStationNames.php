<?php

namespace App\GraphQL\Queries;
use App\Models\Station;
use Illuminate\Support\Facades\Log;

final class FinnishStationNames
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = [];
        $stations = Station::all()->sortBy('nimi');

        foreach ($stations as $s) {

            array_push(
                $val,
                new Station(['stationID' => $s->stationID,'nimi' => $s->nimi])
            );


        };

        return $val;
    }
}
