<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $users = App\Models\User::all();
    return view('welcome');
});

Route::get('/users', function () {

    $users = App\Models\User::all();
    return "<p>Käyttäjiä on yhteensä: ".count($users)." kpl</p>";

});

/*
Product::where('name_en', 'LIKE', '%'.$search.'%')->get();

$stations = App\Models\Station::all();
*/
Route::get('/stations', function() {
    $stations = App\Models\Station::all();
    $f1= $stations->where('stationID', 1)->first()->nimi;
    $f2= $stations->where('stationID', 2)->first()->nimi;
    $f3= $stations->where('stationID', 3)->first()->nimi;
    $f4= $stations->where('stationID', 4)->first()->nimi;
    dd($f4);
    // return "<p>Asemia on yhteensä: ".count($stations)." kpl</p>";
});
