<?php

namespace App\GraphQL\Builders;

use Illuminate\Support\Facades\DB;
use App\Models\Trip;

//use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

/*
https://github.com/nuwave/lighthouse/issues/608
*/
class JourneyBuilder {

    public function findJourneys($root, array $args): Builder
    {

        Log::info(json_encode($args));
        // $stations = Station::where('nimi', 'LIKE', $searchStr.'%')->orderBy($orderBy, $order)->get();
        // $songs->sortByDesc('lastDate');
        return Trip::query();
    }
}