<?php

namespace App\GraphQL\Queries;

use App\Models\Trip;
use Illuminate\Support\Facades\Log;

final class Journeys
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = [];

        $trips = Trip::all();
        Log::info(json_encode(". _invoke"));


        return $val;
    }
}
