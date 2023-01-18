<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
departureStationID	
lkm	
maxDistance	
avgDistance
minDistance	
maxDuration
avgDuration
minDduration
*/
class TripsByDepartureStation extends Model
{
    protected $fillable = [
        'departureStationID',
        'departureStationName',
        'lkm',
        'maxDistance',
        'avgDistance',
        'minDistance',
        'maxDuration',
        'avgDuration',
        'minDuration',
    ];
}
