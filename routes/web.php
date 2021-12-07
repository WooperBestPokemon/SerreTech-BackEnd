<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GreenHouse\{addGreenHouseController, deleteGreenHouseController, editGreenhouseController};
use App\Http\Controllers\Sensor\{addSensorController, deleteSensorController, editSensorController};
use App\Http\Controllers\Zone\{addZoneController, deleteZoneController,editZoneController};
use App\Http\Controllers\{gestionController,NotificationController};
use App\Http\Controllers\Company\addCompanyController;
use App\Http\Controllers\Employe\{addEmployeController, deleteEmployeController,editEmployeController};
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

    Route::delete('/admin/greenhouse/delete/{idGreenhouse}',deleteGreenHouseController::class)->name("deletegreenhouse");

    /*
    |--------------------------------------------------------------------------
    | Admin Zone
    |--------------------------------------------------------------------------
    */

    Route::get("/admin/zone/add",addZoneController::class)->name("addzone");

    Route::post("/admin/zone/add",[addZoneController::class,'insert'])->name("addzonePost");

    Route::get('/admin/zone/{idZone}/edit' , editZoneController::class)->name("editzone");

    Route::put('/admin/zone/{idZone}/edit',[editZoneController::class,'update'])->name("editzonePut");

    Route::delete('/admin/zone/delete/{idZone}',deleteZoneController::class)->name("deletezone");

    /*
    |--------------------------------------------------------------------------
    | Admin Sensors
    |--------------------------------------------------------------------------
    */

    Route::get("/admin/sensor/add",addSensorController::class)->name("addsensor");

    Route::post("/admin/sensor/add",[addSensorController::class,'insert'])->name("addsensorPost");

    Route::get('/admin/sensor/{idSensor}/edit' , editSensorController::class)->name("editsensor");

    Route::get('/notification', [NotificationController::class, "GetNotification"]);

    Route::put('/admin/sensor/{idSensor}/edit' ,[editSensorController::class,'update'])->name("editsensorPut");

    Route::delete('/admin/sensor/delete/{idSensor}',deleteSensorController::class)->name("deletesensor");

    /*
    |--------------------------------------------------------------------------
    | Admin Employes
    |--------------------------------------------------------------------------
    */

    Route::get("/admin/employe",[gestionController::class, 'employe'])->name("employe");

    Route::get("/admin/employe/add",[addEmployeController::class,'index'])->name("addEmploye");

    Route::post("/admin/employe/add",[addEmployeController::class,'insert'])->name("addEmployePost");

    Route::get('/admin/employe/{idProfile}/edit' , [editEmployeController::class,'__invoke'])->name("editEmploye");

    Route::put('/admin/employe/{idProfile}/edit',[editEmployeController::class,'update'])->name("editEmployePut");

    Route::delete('/admin/employe/delete/{idUser}',deleteEmployeController::class)->name("deleteuser");

    Route::get("/addCompagn13", addCompanyController::class)->name("addCompany");

    Route::post("/addCompagn13/add",[addCompanyController::class,'insert'])->name("addCompanyPost");

});
/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/
//

Auth::routes();

//Route::get('/home', function (){return redirect("admin");})->name('home2');

