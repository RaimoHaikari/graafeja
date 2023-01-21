<?php

namespace App\GraphQL\Queries;

use App\Models\Station;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Summary AS SummaryModel;
use App\Models\StationsByCity;
use App\Models\EventsInDay;
use App\Models\EventsByDayOfTheWeek;
<<<<<<< HEAD
=======
>>>>>>> f209caccd7ac647ca4e7ba94f485ae681512ef07

final class Summary
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // Haetaan asemat
        $stations = Station::all();

        return new SummaryModel([
            'number_of_stations' => count($stations),
            'number_of_bikes' => $stations->sum('kapasiteetti'),
            'stations_by_city' => $this->getStationsByCity(),
            'events_in_day' => $this->getEventsInDay(),
            'events_by_the_dayOfWeek' => $this->getEventsByTheDayOfTheWeek()
        ]);
    }

    private function getEventsByTheDayOfTheWeek(){
        $val = [];

        $query = <<<END
        SELECT dep_Weekday, COUNT(*) as lkm
        FROM trips
        GROUP BY dep_Weekday
      END;

        $data = DB::select($query);
        
        foreach ($data as $d) {
            array_push(
                $val, 
                new EventsByDayOfTheWeek(
                    [
                        'day_of_week' => $d->dep_Weekday,
                        'number_of_events' =>  $d->lkm
                    ]
                )
            );
        }

        return $val;
    }



    private function getEventsInDay() {
        $val = [];

        $query = <<<END
        SELECT dep_Month, dep_day, COUNT(*) as lkm
        FROM trips
        GROUP BY dep_Month, dep_day
        ORDER BY lkm DESC
      END;

        $data = DB::select($query);

        
        foreach ($data as $d) {
            array_push(
                $val, 
                new EventsInDay(
                    [
                        'day' => $d->dep_day,
                        'month' => $d->dep_Month,
                        'number_of_events' =>  $d->lkm
                    ]
                )
            );
        }
        
        return $val;

    }

    private function getStationsByCity(){

        $val = [];

        $query = <<<END
        SELECT kaupunki, COUNT(*) lkm
        FROM stations
        GROUP BY kaupunki
        ORDER BY lkm DESC
      END;

        $data = DB::select($query);

        
        foreach ($data as $d) {
            array_push(
                $val, 
                new StationsByCity(
                    [
                        'city' => $d->kaupunki,
                        'number_of_stations' =>  $d->lkm
                    ]
                )
            );
        }


        return $val;

    }
<<<<<<< HEAD
}
=======
}
>>>>>>> f209caccd7ac647ca4e7ba94f485ae681512ef07
