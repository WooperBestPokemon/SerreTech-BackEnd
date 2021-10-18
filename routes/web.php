<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GreenHouse\{AddGreenhouseController, EditGreenhouseController};
use App\Http\Controllers\Sensor\{AddSensorController, EditSensorController};
use App\Http\Controllers\Zone\{AddZoneController,EditZoneController};
use App\Http\Controllers\gestionController;
use App\Http\Controllers\Auth\VerificationController;
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

    Route::get("/admin",[GestionController::class, 'index'])->name("admin");

    Route::get("/admin/gestion",GestionController::class)->name("adminGestion");
    /*x
    |--------------------------------------------------------------------------
    | Admin Greenhouse
    |--------------------------------------------------------------------------
    */

    Route::get("/admin/greenhouse/add", AddGreenhouseController::class)->name("addgreenhouse");

    Route::post("/admin/greenhouse/add",[AddGreenhouseController::class,'insert'])->name("addgreenhousePost");

    Route::get('/admin/greenhouse/{idGreenhouse}/edit',EditGreenhouseController::class)->name("editgreenhouse");

    Route::put('/admin/greenhouse/{idGreenhouse}/edit',[EditGreenhouseController::class,'update'])->name("editgreenhousePut");

    /*
    |--------------------------------------------------------------------------
    | Admin Zone
    |--------------------------------------------------------------------------
    */

    Route::get("/admin/zone/add",AddZoneController::class)->name("addzone");

    Route::post("/admin/zone/add",[AddZoneController::class,'insert'])->name("addzonePost");

    Route::get('/admin/zone/{idZone}/edit' , EditZoneController::class)->name("editzone");

    Route::put('/admin/zone/{idZone}/edit',[EditZoneController::class,'update'])->name("editzonePut");

    /*
    |--------------------------------------------------------------------------
    | Admin Sensors
    |--------------------------------------------------------------------------
    */

    Route::get("/admin/sensor/add",AddSensorController::class)->name("addsensor");

    Route::post("/admin/sensor/add",[AddSensorController::class,'insert'])->name("addsensorPost");

    Route::get('/admin/sensor/{idSensor}/edit' , EditSensorController::class)->name("editsensor");

    Route::put('/admin/sensor/{idSensor}/edit' ,[EditSensorController::class,'update'])->name("editsensorPut");

});
/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/
//
// Route::get('/register', function (){return redirect("home");});

Route::get("/login",function (){
    return view('auth.login');
})->middleware('auth')->name('login');

//Route::get('/home', function (){return redirect("admin");})->name('home2');

