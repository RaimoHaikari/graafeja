# Helsinki city bike app

Tämä on Helsingin kaupungin lainapyörillä tehtyjä matkoja visualisoivan sovelluksen backend.

- Backend on toteuttu [Laravel-sovelluskehykseen](https://laravel.com/) avulla. 
- Tiedot on tallellettu MariaDB tietokantaan.
- Yhteydenpito front- ja backEnd:in välillä tapahtuu GraphQL-kyselyjen välityksellä.
- BackEnd:in GraphQL toiminallisuus on toteutettu [Lighthouse](https://lighthouse-php.com/) kirjaston avulla.

GraphQL -kyselyitä voi testata osoitteessa [http://graafeja.tahtisadetta.fi/graphiql](http://graafeja.tahtisadetta.fi/graphiql).

### Aineisto

Aineistona käytetään kesällä 2021 Helsingin kaupungin lainapyörillä ajetuista matkoista kerättyä tietoa. 

Sovelluksessa on käytössä tietoa kolmen kuukauden ajalta, kattaen touko- ja heinäkuun aikana suoritetut matkat.

Tiedot ovat peräisi Solita Oy:n Dev Academyn esivalintatehtävästä ja löytyvät osoitteesta: [https://github.com/solita/dev-academy-2023-exercise](https://github.com/solita/dev-academy-2023-exercise).

Aineiston alkuperäinen tuottaja on [HSL](https://www.hsl.fi/en/hsl/open-data).

### Asennus

Asennuksessa tarvittavat toimenpiteet riippuvat hieman siitä onko koodia tarkoitus ajaa omalla tietokoneella olevassa kehitysympäristössä vai Internet-palveluntarjoajan ympäristössä.

Seuraavat ohjeet on laadittu kotikoneelle tapahtuva asennusta silmällä pitäen.

#### Lähtöoletukset

Asennus edellyttää, että käytössä on:

- [Git](https://git-scm.com/)-versionhallintaohjelmisto
- PHP:tä ja mySql:ää tukeva webpalvelin, esim. [Xampp](https://www.apachefriends.org/)
- PHP:n versionhallintaohjelmisto [Composer](https://getcomposer.org/)

#### Tietokanta

Sovellus edellyttää tietokannan käyttöä, joten ensimmäisenä toimenpiteenä kannattaa luoda tietokanta ja käyttäjätili, jonka kautta Laravel pystyy tietokantaa käyttämään.

Kotikoneella yksinkertaisimmillaan riittää kun suorittaa phpMyAdmin-ikkunassa SQL-komennon:

```
CREATE DATABASE <tietokannan nimi>;
```

Ympäristöstä riippuen tietokannan käyttö saattaa lisäksi edellyttää, että:

- luodaan uusi käyttäjä
- määritetään tälle salasana
- annetaan em. käyttäjälle päivitysoikeudet juuri luotuu tietokantaan.

Omalla koneellani käytän Xampp asennuksen oletusarvoja, joissa __root-käyttäjällä__ on täydet oikeudet kaikkiin tietokantoihin, eikä __root-käyttäjälle__ ole asetettu salasanaa. 

Minulla on tässä vaiheessa siis koossa seuraavat tiedot:

   tietokanta = laravel  
   käyttäjätunnus = root  
   salasana =  

Kirjoita vastaavat tiedot ylös, niitä tarvitaan pian!

#### Koodin asennus

GitHubissa oleva sovellusrunko kloonataan sopivaan paikkaan:

```
git clone https://github.com/fullstack-hy2020/bloglist-frontend
```

Siirrytään em. vaiheessa luotuun kansioon ja ajetaan Composerin asennuskomento.

```
composer install
```

Kun asennus on valmis, pitää luoda __.env -tiedosto__. Käytetään apuna asennuksen mukana tulevaa __.env.example__-tiedostoa:

```
cp .env.example .env
```

Luodusta .env -tiedostosta löyty tietokantayhteyksiä koskeva kohta. Lisätään tietokannan luomisen yhteydessä määritetyt tiedot siihen.

Minun tapauksessani tiedot ovat seuraavat:

```
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Luodaan [__key__](https://stackoverflow.com/questions/33370134/when-to-generate-a-new-application-key-in-laravel):

```
php artisan key:generate
```

Luodaan käytettävät tietokantataulut:

```
php artisan migrate
```

Githubista kloonattu repository pitää sisällään touko- ja kesäkuun matkat. Ne löytyvät tiedostosta \database\data\2021-05-Prod.csv.

Alustetaan tietokanta näillä tiedoilla:

```
php artisan db:seed --class=DatabaseSeeder
```

Siemenenä käytettävän tiedoston koko on 80 MB, joten tietojen luku kestää jonkin aikaa. Omalla koneellani tämä vaihe vie noin 2 minuuttia.

Tässä vaiheessa kaiken pitäisi ollan käyttövalmiina.

Käynnistetään palvelin:

```
php artisan serve
```

Backend on käytössä vain tiedon varastointia ja GraphQl kyselyitä varten, joten se ei tavallan tulosta mitään erityistä.

Mutta esim. GraphQL-kyselyjen "playground" löytyy nyt osoitteesta: 

```
http://localhost:8000/graphiql
```

### Tietokanta

Lainauksia on melkoisen paljon, mikä ilmenee loppukäyttäjälle toiminnan viiveenä. Mahdollisen tuotantokäyttöön tarkoitetun sovelluksen toimintaa olisi mahdollista nopeuttaa laskemalla etukäteen valmiiksi aineistosta koostettavia arvoja ja päivittämällä näitä laskelmia aina aineiston muutosten yhteydessä.

Tämän projektin yhteydessä em. kaltaista toiminallisuutta ei ollut järkevää toteuttaa.

Tietokanta sisältää seuraavat taulut:

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

Backend tarjoaa ulkomaailmaan GraphQl-rajapinnan, jota kautta aineistosta koostettua tietoa on mahdollista hakea.

Käydään läpi tuetut kyselyt ja käytetyt tietotyypit.

#### Kyselyt


##### journeys

Palauttaa lainatapahtumista talletetut perustiedot

__Parametrit__

| orderBy | [orderBy -lauseke](https://lighthouse-php.com/5/digging-deeper/ordering.html#client-controlled-ordering) | Tulosten lajitteluperuste |
| page | int! | Tulostettava sivu |
| first | int! | Montako tulosta kerralla halutaan |

***Palauttaa***

Aseman perustiedot sisältävän [Trip](#trip)-objektin sekä Paginator-objektin.

Paginator-objektin avulla saadaan selville mm. kyselyn tuottamien tulosten kokonaismäärä, kerralla näytettävien tulosten määrä, löytyykö aktiivisen sivun jälkeen lisää sivuja jne. Lisätietoa Paginator-objektista löydät esim. [täältä](https://graphql.org/learn/pagination/).

**Esimerkki**

```
{
  journeys(first:10, page:2){
    data {
      departureStationName
      returnStationName
      coveredDistance
    }
    paginatorInfo {
      hasMorePages
    }
  }
}
```

##### station

Lainausaseman perustietojen haku.

__Parametrit__

| Kenttä | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| stationID | Int! | Aseman id-tunnus |

***Palauttaa***

Aseman perustiedot sisältävän [Station](#station-1)-objektin.

**Esimerkki**

```
{
  station(stationID:23) {
    stationID
    nimi
    osoite
  }
}
```

##### stations

Parametrillä __searchStr__ annetulla merkkijonolla alkavat asemat. Parametri __searchStr__ on pakollinen, mutta se voidaan jättää tyhjäksi, tällöin kysely hakee kaikki asemat.

__Parametrit__

| Kenttä | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| searchStr | String! | Hakutermi |
| orderBy | [orderBy -lauseke](https://lighthouse-php.com/5/digging-deeper/ordering.html#client-controlled-ordering) | Tulosten lajitteluperuste |
| page | int! | Tulostettava sivu |
| first | int! | Montako tulosta kerralla halutaan |

Huom.

Lajitteluperusteena voidaan käyttää ainoastaan aseman suomenkielistä nimeä.

Yhdellä kertaa palautettavien tietojen määrä asetetaan parametrien __page__ ja __first__ avulla. 

- __first__ kuinka monta tulosta kerralla palautetaan
- __page__ monesko sivu tuloksista halutaa, kun huomioidaan palautettava sivumäärä.

***Palauttaa***

Aseman perustiedot sisältävän [Station](#station-1)-objektin sekä Paginator-objektin.

Paginator-objektin avulla saadaan selville mm. kyselyn tuottamien tulosten kokonaismäärä, kerralla näytettävien tulosten määrä, löytyykö aktiivisen sivun jälkeen lisää sivuja jne. Lisätietoa Paginator-objektista löydät esim. [täältä](https://graphql.org/learn/pagination/).

**Esimerkki**

```
{
  stations(searchStr: "A", orderBy:[{column:NIMI, order: DESC}], page: 1, first: 10) {
    data {
      stationID
      nimi
    }
    paginatorInfo {
      count
      currentPage
    }
  }
}
```


##### summary

Palauttaa yhteenvedon lainaustoiminnasta.

***Palauttaa***

Aseman toiminnan yhteenvedon sisältävän [Summary](#summary-1)-objektin.

**Esimerkki**

```
{
  summary {
    number_of_stations
    number_of_bikes
  }
}
```


#### Tietotyypit

##### EventsByDayOfTheWeek

Montako lainaustapahtumaa tiettynä viikonpäivänä suoritettiin

| Kenttä | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| day_of_week | Int! | Viikonpäivän järjestysnumero |
| number_of_events | Int! | Lainaustapahtumien määrä |

##### EventsByMonth

| Kenttä | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| month | Int! | Kuukauden järjestysnumero |
| number_of_events | Int! | Lainaustapahtumien määrä |


##### EventsInDay

Montako lainaustapahtumaa tiettynä päivänä suoritettiin.

| Kenttä | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| day | Int! | Päivä |
| month | Int! | Kuukausi |
| number_of_events | Int! | Lainaustapahtumien määrä |

##### Station

Lainausaseman perustiedot.

| Kenttä | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| stationID | Int! | Aseman id-tunnus |
| nimi | String! | Aseman suomenkielinen nimi |
| namn | String | Aseman ruotsinkielinen nimi |
| name | String | Aseman englanninkielinen nimi |
| osoite | String | Aseman katuosoite |
| adress | String | Aseman ruotsinkielinen katuosoite |
| kaupunki | String | Aseman sijaintikunnan nimi |
| stad | String | Sijaintikunnan ruotsinkielinen nimi |
| kapasiteetti | Int | Montako pyörää asemalta löytyy |
| x | Float | Sijantipaikan x-koordinaatti |
| y | Float | Sijaintipaika y-koordinaatti |

##### StationsByCity

Montako lainausasemaa kaupungin alueella sijaitsee.

| Kenttä | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| city | String! | Kaupungin nimi |
| number_of_stations | Int! | Lainausasemien määrä |


##### Summary

Lainaustoiminnan perustiedot.

| Kenttä | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| number_of_stations | Int! | Lainausasemien kokonaismäärä |
| number_of_bikes | Int! | Lainattavien pyörien kokonaismäärä |
| stations_by_city | [StationsByCity](#stationsbycity) | Montako lainausasemaa kaupungin alueella sijaitsee |
| events_in_day | [EventsInDay](#eventsinday) | Montako lainausasemaa eri päivinä tehtiin |
| events_by_the_dayOfWeek | [EventsByDayOfTheWeek](#eventsbydayoftheweek) | Montako lainausasemaa eri viikonpäivinä tehtiin |
| events_by_month | [EventsByMonth](#eventsbymonth) | Montako lainausasemaa eri kuukausina|


##### Trip

Lainaustapahtuman perustiedot.

| Kenttä | Tyyppi | Sisältö |
| :--- | :--- | :--- |
| departureStationID | Int! | Lainausaseman id-tunnus |
| returnStationId | Int! | Palautusaseman id-tunnus |
| coveredDistance | Int! | Matkan pituus |
| duration | Int! | Matkan kesto |
| departureStationName | String! | Lainausaseman nimi |
| returnStationName | String! | Palautusaseman nimi |



