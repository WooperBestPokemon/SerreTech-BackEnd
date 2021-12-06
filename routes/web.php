<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GreenHouse\{addGreenHouseController, deleteGreenHouseController, editGreenhouseController};
use App\Http\Controllers\Sensor\{addSensorController, deleteSensorController, editSensorController};
use App\Http\Controllers\Zone\{addZoneController, deleteZoneController, editZoneController};
use App\Http\Controllers\gestionController;
//use App\Http\Controllers\Auth\VerificationController;
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


Route::middleware('auth')->group(function () {

    Route::get('/', function () {return view('welcome');})->name("home");

    Route::get('/greenhouse', function (){return redirect("home");});

    Route::get('/greenhouse/{idGreenhouse}')->name("dtlGreenHouse");

    Route::get("/zone/{idZone}")->name("dtlZones");

    Route::get("/greenhouse/{idGreenhouse}/listsensor")->name("listsensor");

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::get("/admin",[gestionController::class, 'index'])->name("admin");

    Route::get("/admin/gestion",gestionController::class)->name("adminGestion");
    /*x
    |--------------------------------------------------------------------------
    | Admin Greenhouse
    |--------------------------------------------------------------------------
    */

    Route::get("/admin/greenhouse/add", addGreenHouseController::class)->name("addgreenhouse");

    Route::post("/admin/greenhouse/add",[addGreenHouseController::class,'insert'])->name("addgreenhousePost");

    Route::get('/admin/greenhouse/{idGreenhouse}/edit',editGreenhouseController::class)->name("editgreenhouse");

    Route::put('/admin/greenhouse/{idGreenhouse}/edit',[editGreenhouseController::class,'update'])->name("editgreenhousePut");

    Route::delete('/admin/greenhouse/{idGreenhouse}',deleteGreenhouseController::class)->name("deletegreenhouse");

    /*
    |--------------------------------------------------------------------------
    | Admin Zone
    |--------------------------------------------------------------------------
    */

    Route::get("/admin/zone/add",addZoneController::class)->name("addzone");

    Route::post("/admin/zone/add",[addZoneController::class,'insert'])->name("addzonePost");

    Route::get('/admin/zone/{idZone}/edit' , editZoneController::class)->name("editzone");

    Route::put('/admin/zone/{idZone}/edit',[editZoneController::class,'update'])->name("editzonePut");

    Route::delete('/admin/zone/{idZone}',deleteZoneController::class)->name("deletezone");
    /*
    |--------------------------------------------------------------------------
    | Admin Sensors
    |--------------------------------------------------------------------------
    */

    Route::get("/admin/sensor/add",addSensorController::class)->name("addsensor");

    Route::post("/admin/sensor/add",[addSensorController::class,'insert'])->name("addsensorPost");

    Route::get('/admin/sensor/{idSensor}/edit' , editSensorController::class)->name("editsensor");

    Route::put('/admin/sensor/{idSensor}/edit' ,[editSensorController::class,'update'])->name("editsensorPut");

    Route::delete('/admin/sensor/{idSensor}',deleteSensorController::class)->name("deletesensor");
});
/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/
//

Auth::routes();

Route::get('/admin/test', gestionController::class)->name("hom1e");

//Route::get('/home', function (){return redirect("admin");})->name('home2');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
