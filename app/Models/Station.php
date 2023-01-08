<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    /*
     * stationID
     * nimi
     * namn
     * name
     * osoite
     * adress
     * kaupunki
     * stad
     * kapasiteetti
     * x
     * y
     */
    protected $fillable = [
        'stationID', 
        'nimi', 
        'namn', 
        'name', 
        'osoite',
        'adress', 
        'kaupunki', 
        'stad', 
        'kapasiteetti', 
        'x',
        'y',
    ];
}
