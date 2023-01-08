<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Station extends Migration
{
    /**
     * Run the migrations.
     * 
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
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->integer('stationID');
            $table->string('nimi');
            $table->string('namn');
            $table->string('name');
            $table->string('osoite');
            $table->string('adress');
            $table->string('kaupunki');
            $table->string('stad');
            $table->string('kapasiteetti');
            $table->float('x', 10, 8);
            $table->float('y', 10, 8);
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
