<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\viewDataController;
use App\Http\Controllers\addDataController;
use App\Http\Controllers\addGreenhouseController;
use App\Http\Controllers\addZoneController;
use App\Http\Controllers\addSensorController;
use App\Http\Controllers\gestionController;

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
    return view('welcome');
});

Route::get('/viewData', [viewDataController::class, '__invoke']);



//Vue gestion /admin
Route::get('/admin', [gestionController::class, 'index']);
Route::get('/adminView', [gestionController::class, '__invoke']);

//Creer des datas tblTest
Route::get('addDataJerome','addDataController@index');
Route::post('createData','addDataController@insert');

//Creer des greenhouse tblGreenhouse
Route::get('addGreenhouse','addGreenhouseController@__invoke');
Route::post('createGreenhouse','addGreenhouseController@insert');

//Creer des zone tblZone
Route::get('addZone','addZoneController@__invoke');
Route::post('createZone','addZoneController@insert');

//Creer des capteur tblSensor
Route::get('addSensor','addSensorController@__invoke');
Route::post('createSensor','addSensorController@insert');
