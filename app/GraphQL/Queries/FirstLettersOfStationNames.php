<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/*
 * Asemalistausta varten laaditaan luettelo suomenkielisien asemanimien
 * alkukirjaimista.
 */
final class FirstLettersOfStationNames
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $val = [];

        $query = <<<END
        SELECT DISTINCT SUBSTRING(nimi, 1,1) Alkukirjain
        FROM stations
        ORDER BY Alkukirjain
      END;

        $data = DB::select($query);

        foreach ($data as $d) {
            array_push($val, $d->Alkukirjain);
        }

        return $val;
    }
}
