<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsByMonth extends Model
{
    protected $fillable = [
        'month',
        'number_of_events'
    ];
}
