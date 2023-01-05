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

Route::get('/stations', function() {
    $stations = App\Models\Station::all();
    return "<p>Asemia on yhteensä: ".count($stations)." kpl</p>";
});
