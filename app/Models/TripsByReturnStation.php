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
class TripsByReturnStation extends Model
{
    protected $fillable = [
        'returnStationID',
        'lkm',
        'maxDistance',
        'avgDistance',
        'minDistance',
        'maxDuration',
        'avgDuration',
        'minDuration',
    ];
}
