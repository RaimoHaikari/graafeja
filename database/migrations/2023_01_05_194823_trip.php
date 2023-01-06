<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Trip extends Migration
{
    /**
     * Run the migrations.
     * 
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
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->integer('departureStationID');
            $table->integer('returnStationId');
            $table->integer('coveredDistance');
            $table->integer('duration');
            $table->integer('dep_H');
            $table->integer('dep_M');
            $table->integer('dep_Day');
            $table->integer('dep_Weekday');
            $table->integer('dep_Month');
            $table->integer('dep_Year');

            $table->integer('ret_H');
            $table->integer('ret_M');
            $table->integer('ret_Day');
            $table->integer('ret_Weekday');
            $table->integer('ret_Month');
            $table->integer('ret_Year');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stations');
    }
}
