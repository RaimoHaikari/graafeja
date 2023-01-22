<?php

namespace App\Models;

use App\Models\Station;

use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    protected $fillable = [
        'number_of_stations',
        'number_of_bikes',
        'stations_by_city',
        'events_in_day',
        'events_by_the_dayOfWeek',
        'events_by_month'
    ];
}
