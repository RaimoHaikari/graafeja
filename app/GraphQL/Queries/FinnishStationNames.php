<?php

namespace App\GraphQL\Queries;
use App\Models\Station;

final class FinnishStationNames
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $stations = Station::all()->pluck('nimi')->toArray();
        return $stations;
    }
}
