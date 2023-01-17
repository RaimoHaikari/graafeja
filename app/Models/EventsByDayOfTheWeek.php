<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsByDayOfTheWeek extends Model
{
    protected $fillable = [
        'day_of_week',
        'number_of_events'
    ];
}
