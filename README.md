# Helsinki city bike app

Tämä on Helsingin kaupungin lainapyörillä tehtyjä matkoja visualisoivan sovelluksen backendin repository.

- Backend on toteuttu [Laravel-sovelluskehykseen](https://laravel.com/) avulla. 
- Tiedot on tallellettu MariaDB tietokantaan.
- Yhteydenpito front- ja backEnd:in välillä tapahtuu GraphQL-kyselyjen välityksellä.
- BackEnd:in GraphQl toiminallisuus on toteutettu [Lighthouse](https://lighthouse-php.com/) kirjaston avulla.

GraphQL -kyselyistä voi testata osoitteessa [http://graafeja.tahtisadetta.fi/graphiql](http://graafeja.tahtisadetta.fi/graphiql).

### Aineisto

Aineistona käytetään kesällä 2021 Helsingin kaupungin lainapyörillä ajetuista matkoista kerättyä tietoa. 

Sovelluksessa on käytössä tietoa kolmen kuukauden ajalta, kattaen touko- ja heinäkuun aikana suoritetut matkat.

Tiedot ovat peräisi Solita Oy:n Dev Academyn esivalintatehtävästä ja löytyvät osoitteesta: [https://github.com/solita/dev-academy-2023-exercise](https://github.com/solita/dev-academy-2023-exercise).

Aineiston alkuperäinen tuottaja on [HSL](https://www.hsl.fi/en/hsl/open-data).

### Tietokanta

#### stations

Laina-asemien perustiedot

| Sarake | Tyyppi | Sisältö |
| :---         |     :---      | :--- |
| stationID   | integer    | Aseman id-tunnus |
| nimi     | string       | Suomenkielinen nimi  |
| namn     | string       | Ruotsinkielinen nimi  |
| name     | string       | Englanninkielinen nimi  |
| osoite     | string       | Katuosoite |
| adress     | string       | Ruotsinkielinen katuosoite  |
| kaupunki     | string       | Sijaintikaupunki  |
| stad     | string       | Sijaintikaupungin ruotsinkielinen nimi |
| kaupunki     | integer       | Lainattavien pyörien lkm  |
| x     | float(10, 8)       | Aseman x koordinaatti  |
| y     | float(10, 8)       |  Aseman y koordinaatti  |

#### trips

Pyörillä tehdyt reissut.

| Sarake | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| departureStationID | integer | Lainausaseman id-tunnus |
| returnStationId | integer | Palautussaseman id-tunnus |
| coveredDistance | integer | Kuljettu matka metreinä |
| duration | integer | Laina-aika sekunteina |
| dep_H | integer | Lainausajankohdan tunti |
| dep_M | integer | Lainausajankohdan minuutit |
| dep_Day | integer | Lainausajankohdan päivä |
| dep_Weekday | integer | Lainausajankohdan viikonpäivä |
| dep_Month | integer | Lainausajankohdan kuukausi |
| dep_Year | integer | Lainausajankohdan vuosi |
| ret_H | integer | Palautusajankohdan tunti |
| ret_M | integer | Palautusajankohdan minuutit |
| ret_Day | integer | Palautusajankohdan päivä |
| ret_Weekday | integer | Palautusajankohdan viikonpäivä |
| ret_Month | integer | Palautusajankohdan kuukausi |
| ret_Year | integer | Palautusajankohdan vuosi |

Lisäksi on käytössä kaksi näkymää.

#### tripsByDepartureStation

Yhteenveto lainoista asemittain.

| Sarake | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| departureStationID | integer | Lainausaseman id-tunnus |
| lkm | integer | Lainojen kokonaismäärä |
| maxDistance | integer | Pisin lainareissu metreinä |
| avgDistance | float | Keskimääräinen lainareissu metreinä |
| minDistance | integer | Lyhin lainareissu metreinä |
| maxDuration | integer | Pisin laina-aika sekunteina |
| avgDuration | float | Keskimääräinen laina-aika sekunteina |
| minDuration | integer | Lyhin laina-aika sekunteina |

#### tripsByReturnStation

Yhteenveto palautuksista asemittain

| Sarake | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| returnStationId | integer | Palautusaseman id-tunnus |
| lkm | integer | Palautusten kokonaismäärä |
| maxDistance | integer | Pisin lainareissu metreinä |
| avgDistance | float | Keskimääräinen lainareissu metreinä |
| minDistance | integer | Lyhin lainareissu metreinä |
| maxDuration | integer | Pisin laina-aika sekunteina |
| avgDuration | float | Keskimääräinen laina-aika sekunteina |
| minDuration | integer | Lyhin laina-aika sekunteina |

### GraphQL


