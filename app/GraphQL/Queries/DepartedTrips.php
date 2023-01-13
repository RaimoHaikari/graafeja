<?php

namespace App\GraphQL\Queries;

use App\Models\Station;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\DepartedTrips AS DepartedTripsModel;

/*
 * Resolveri, joka vastaa kysymykseen mihinkä asemalta alkaneet reissut päättyivät.
 * - osa palauttaa pyörän samaan paikkaa mistä sen lainasikin
 * - enemmistö kuitenkin on matkalla "jonnekin muualle"
 */
final class DepartedTrips
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = array();

        $departureStationID = $args['departureStationID'];

        $query = <<<END
        SELECT departureStationID, returnStationId, count(*) as lkm
        FROM trips
        WHERE departureStationID = $departureStationID
        GROUP BY departureStationID, returnStationId
        ORDER BY lkm DESC
      END;

        $data = DB::select($query);

        // Haetaan myös asemien nimitiedot
        $stations = Station::all();

        // $this->getStationNames();

        foreach ($data as $d) {
            
            $departureStation = $stations->where('stationID',  $d->departureStationID)->first();
            $returnStation =  $stations->where('stationID',  $d->returnStationId)->first();
            //Log::info((json_encode($d->returnStationId)));

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

    private function getStationNames(){
        $stations = Station::all();

        $filtered = $stations->where('stationID', 1)->first()->nimi;
        Log::info((json_encode($filtered)));

    }
}