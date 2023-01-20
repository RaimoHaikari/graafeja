<?php

namespace App\GraphQL\Builders;

use App\Models\Station;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class StationBuilder {

    public function findStations($root, array $args): Builder
    {

        //Log::info(json_encode($args));
        // $stations = Station::where('nimi', 'LIKE', $searchStr.'%')->orderBy($orderBy, $order)->get();

        return Station::query()
            ->when($args['searchStr'], function($query, $searchStr){

                $query
                    ->where('nimi', 'LIKE', "$searchStr%");
            });
    }
}