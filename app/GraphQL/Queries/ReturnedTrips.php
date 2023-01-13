<?php

namespace App\GraphQL\Queries;

use App\Models\Station;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\DepartedTrips AS DepartedTripsModel;

/*
 * Resolveri, joka vastaa kysymykseen: mistä asemalle palautetut pyörät lainattiin.
 * - osa palauttaa pyörän samaan paikkaa mistä sen lainasikin
 * - enemmistö on kuitenkin tulossa jostain muualta
 */
final class ReturnedTrips
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = array();

        $returnStationID = $args['returnStationID'];

        $query = <<<END
        SELECT departureStationID, returnStationId, count(*) as lkm
        FROM trips
        WHERE returnStationId = $returnStationID
        GROUP BY departureStationID, returnStationId
        ORDER BY lkm DESC
      END;

        $data = DB::select($query);

        // Haetaan myös asemien nimitiedot
        $stations = Station::all();

        // $this->getStationNames();

        foreach ($data as $d) {

            $departureStation = $stations->where('stationID',  $d->departureStationID)->first();
            
            //$departureStationName = $stations->where('stationID',  $d->departureStationID)->first()->nimi;
            $returnStation = $stations->where('stationID',  $d->returnStationId)->first();
            Log::info((json_encode($returnStation)));

            array_push(
                $val, 
                new DepartedTripsModel(
                    [
                        'departureStationID' => $d->departureStationID,
                        'departureStationNimi' => $departureStation->nimi,
                        'depX' => $departureStation->x,
                        'depY' => $departureStation->y,
                        'returnStationID' => $d->returnStationId,
                        'returnStationNimi' => $returnStation->nimi,
                        'retX' => $returnStation->x,
                        'retY' => $returnStation->y,
                        'lkm' =>  $d->lkm
                    ]
                )
            );
        }
        
        
        return $val;
    }

}