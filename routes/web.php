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

Route::get('/solita', function () {
    return view('solita');
});

Route::get('/users', function () {

    $users = App\Models\User::all();
    return "<p>Käyttäjiä on yhteensä: ".count($users)." kpl</p>";

});

/*
Product::where('name_en', 'LIKE', '%'.$search.'%')->get();

$stations = App\Models\Station::all();
Post::where('id', $id)->first()
*/
Route::get('/stations', function() {

    $stations = App\Models\Station::all()->pluck('nimi')->toArray();
    dd($stations);

});