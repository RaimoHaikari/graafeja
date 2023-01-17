<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StationsByCity extends Model
{
    protected $fillable = [
        'city',
        'number_of_stations'
    ];
}
