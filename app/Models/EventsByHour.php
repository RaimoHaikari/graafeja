<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsByHour extends Model
{
    protected $fillable = [
        'hour',
        'number_of_events'
    ];
}
