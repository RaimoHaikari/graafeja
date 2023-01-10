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
class DepartedTrips extends Model
{
    protected $fillable = [
        'departureStationID',
        'returnStationID',
        'lkm',
    ];
}
