<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DurationBin extends Model
{
    protected $fillable = [
        'bin',
        'number_of_events'
    ];
}
