<?php

namespace App\GraphQL\Queries;
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

/*
$csvFile = fopen(base_path("database/data/2021-05-Prod.csv"), "r");
*/
final class Stations
{
    public function fooBar($rootValue, array $args) {


        return 23;
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