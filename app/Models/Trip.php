<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    /*
     * departureStationId
     * returnStationId
     * coveredDistance
     * duration
     * dep_H
     * dep_M
     * dep_Day
     * dep_Weekday
     * dep_Month
     * dep_Year
     * ret_H
     * ret_M
     * ret_Day
     * ret_Weekday
     * ret_Month
     * ret_Year
     */
    protected $fillable = [
        'departureStationID', 
        'returnStationId', 
        'coveredDistance', 
        'duration',
        'duration',
        'dep_H',
        'dep_M',
        'dep_Day',
        'dep_Weekday',
        'dep_Month',
        'dep_Year',
        'ret_H',
        'ret_M',
        'ret_Day',
        'ret_Weekday',
        'ret_Month',
        'ret_Year'
    ];
}
