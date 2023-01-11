<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
 * 
 */
class DepartedTrips extends Model
{
    protected $fillable = [
        'departureStationID',
        'departureStationNimi',
        'returnStationID',
        'returnStationNimi',
        'lkm',
    ];
}
