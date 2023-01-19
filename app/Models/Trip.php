<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Models\Station;

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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['departureStationName'];

    public function getDepartureStationNameAttribute():String
    {
        $departureStationID = $this->attributes['departureStationID'];
        return Station::where('stationID', $departureStationID)->first()->nimi;
    }

    /*
     * Palautusaseman nimi
     */
    public function getReturnStationName():String
    {
        $returnStationId = $this->attributes['returnStationId'];
        return Station::where('stationID', $returnStationId)->first()->nimi;
    }


}
