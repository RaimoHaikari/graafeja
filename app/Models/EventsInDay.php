<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
  day: Int!
  month: Int!
  number_of_events: Int!
*/
class EventsInDay extends Model
{
    protected $fillable = [
        'day',
        'month',
        'number_of_events'
    ];
}
