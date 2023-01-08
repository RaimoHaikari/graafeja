<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class TripsByReturnStation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    /*
departureStationID	
lkm	
maxDistance	
avgDistance
minDistance	
maxDuration
avgDuration
minDduration
    */
    private function createView(): string
    {
       return <<<SQL
        CREATE VIEW `tripsByReturnStation` AS
        SELECT returnStationId, count(*) as lkm, MAX(coveredDistance) as maxDistance,  AVG(coveredDistance) as avgDistance, MIN(coveredDistance) as minDistance, MAX(duration) as maxDuration,  AVG(duration) as avgDuration, MIN(duration) as minDuration
        FROM trips
        GROUP BY returnStationId
       SQL;
    }

    private function dropView(): string
    {
       return <<<SQL
       DROP VIEW IF EXISTS `tripsByReturnStation`;
       SQL;
    }
}
