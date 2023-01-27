# Helsinki city bike app

Tämä on Helsingin kaupungin lainapyörillä tehtyjä matkoja visualisoivan sovelluksen backendin repository.

- Backend on toteuttu [Laravel-sovelluskehykseen](https://laravel.com/) avulla. 
- Tiedot on tallellettu MariaDB tietokantaan.
- Yhteydenpito front- ja backEnd:in välillä tapahtuu GraphQL-kyselyjen välityksellä.
- BackEnd:in GraphQl toiminallisuus on toteutettu [Lighthouse](https://lighthouse-php.com/) kirjaston avulla.

GraphQL -kyselyitä voi testata osoitteessa [http://graafeja.tahtisadetta.fi/graphiql](http://graafeja.tahtisadetta.fi/graphiql).

### Aineisto

Aineistona käytetään kesällä 2021 Helsingin kaupungin lainapyörillä ajetuista matkoista kerättyä tietoa. 

Sovelluksessa on käytössä tietoa kolmen kuukauden ajalta, kattaen touko- ja heinäkuun aikana suoritetut matkat.

Tiedot ovat peräisi Solita Oy:n Dev Academyn esivalintatehtävästä ja löytyvät osoitteesta: [https://github.com/solita/dev-academy-2023-exercise](https://github.com/solita/dev-academy-2023-exercise).

Aineiston alkuperäinen tuottaja on [HSL](https://www.hsl.fi/en/hsl/open-data).

### Asennus

Asennuksessa tarvittavat toimenpiteet riippuvat hieman siitä onko koodia tarkoitus ajaa omalla tietokoneella olevassa kehitysympäristössä vai internet palveluntarjoajan ympäristössä.

Seuraavat ohjeet on laadittu kotikoneelle tapahtuva asennusta silmällä pitäen.

#### Lähtöoletukset

Asennus edellyttää, että käytössä on:

- Git-versionhallintaohjelmisto
- PHP:tä ja mySql:ää tukeva webpalvelin, esim. Xampp
- PHP:n versionhallintaohjelmisto Composer

#### Tietokanta

Sovellus edellyttää tietokannan käyttöä, joten ensimmäisenä toimenpiteenä pitää luoda tietokanta ja käyttäjätili, jonka kautta Laravel pystyy tietokantaa käyttämään.

Kotikoneella yksinkertaisimmillaan riittää kun suorittaa phpMyAdmin -ikkunassa:

```
CREATE DATABASE <tietokannan nimi>;
```

Yksinkertaisimmillaan tämä riittää. Ympäristöstä riippuen käyttö saattaa edellyttää, että :

- luodaan uusi käyttäjä
- määritetään tälle salasana
- annetaan em. käyttäjälle päivitysoikeudet juuri luotuu tietokantaan.

Omalla koneellani käytän Xampp asennuksen oletusarvoja, joissa **root-käyttäjällä** on täydet oikeudet kaikkiin tietokantoihin, eikä root käyttäjälle ole asetettu salasanaa. 

Minulla on tässä vaiheessa koossa seuraavat tiedot:

   tietokanta = laravel  
   käyttäjätunnus = root  
   salasana =  

Kirjoita vastaavat tiedot ylös, niitä tarvitaan asennuksen loppuvaiheessa!

#### Koodin asennus

GitHubissa oleva sovellusrunko kloonataan sopivaan paikkaan:

```
git clone https://github.com/fullstack-hy2020/bloglist-frontend
```

Siirrytään em. vaiheessa luotuun kansioon ja ajetaan Composerin asennuskomento.

```
composer install
```

Kun asennus on valmis, pitää luoda .env -tiedosto. Käytetään apuna asennuksen mukana tulevaa .env.example -tiedostoa:

```
cp .env.example .env
```

Luodusta .env -tiedostosta löyty tietokantayhteyksiä koskeva kohta. Lisätään tietokannan luomien yhteydessä määritety tiedot siihen.

Minun tapauksessani tiedot ovat seuraavat:

```
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Luodaan "key":

```
php artisan key:generate
```

Luodaan käytettävät tietokantataulut:

```
php artisan migrate
```

Githubista kloonattu repository pitää sisällään touko- ja kesäkuun matkat.

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


