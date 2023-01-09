<?php

namespace App\GraphQL\Queries;
use App\Models\Station;
use Illuminate\Support\Facades\Log;

/*
$csvFile = fopen(base_path("database/data/2021-05-Prod.csv"), "r");
*/
final class Stations
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $searchStr = $args['searchStr'];
        $orderBy = $args['orderBy'][0]['column'];
        $order = $args['orderBy'][0]['order'];

        Log::info(json_encode($args));


        $stations = Station::where('nimi', 'LIKE', $searchStr.'%')->orderBy($orderBy, $order)->get();

        return $stations;
    }

    public function fooBar($rootValue, array $args) {
        return [];
    }

    public function debugger($txt) {
        //$myfile = fopen(base_path("storage/logs/debugger.txt"), "wr") or die("Unable to open file!");
        // fwrite($myfile, $txt);
        $myfile = file_put_contents(
            base_path("storage/logs/debugger.txt"), 
            $txt.PHP_EOL , 
            FILE_APPEND | LOCK_EX
        );
        //fclose($myfile);
    }
}