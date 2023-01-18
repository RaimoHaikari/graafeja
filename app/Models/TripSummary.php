<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*

  'departureStationID',
  'returnStationId',
  'avgDistance',
  'avgDuration',
  'lkm'
*/
class TripSummary extends Model
{
    protected $fillable = [
        'departureStationID',
        'departureStationName',
        'returnStationId',
        'returnStationName',
        'avgDistance',
        'avgDuration',
        'lkm'
    ];
}
