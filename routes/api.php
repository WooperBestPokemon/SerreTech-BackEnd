<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\apiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::fallback(function (){
    abort(response()->json('API resource not found',404));
});

Route::post('/login', [apiController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/GetGreenhouse',[apiController::class, 'ViewGreenHouse']);
    Route::post("/data", [apiController::class, "postData"]);
});


Route::get('/GetZone/{id}',[apiController::class,'ViewZone']);

Route::get('/GetSensor/{id}',[apiController::class,'ViewSensor']);

Route::get('/SearchGreenhouse/{id}',[apiController::class,'SearchGreenhouse']);

Route::get('/SearchZone/{id}',[apiController::class,'SearchZone']);

Route::get('/SearchSensor/{id}',[apiController::class,'SearchSensor']);


/*
|--------------------------------------------------------------------------
| Procedure stockkées
|--------------------------------------------------------------------------
*/


Route::get('/GetDataLastDay/{idSensor}',[apiController::class,'GetDataLastDay']);

Route::get('/GetDataLastWeek/{idSensor}',[apiController::class,'GetDataLastWeek']);

Route::get('/GetDataLastMonth/{idSensor}',[apiController::class,'GetDataLastMonth']);

Route::get('/GetDataLastYear/{idSensor}',[apiController::class,'GetDataLastYear']);

Route::get('/GetAvgDataGreenhouse/{idGreenhouse}/{typedata}',[apiController::class,'GetAvgDataGreenhouse']);

Route::get('/GetAvgDataZone/{idZone}/{typedata}',[apiController::class,'GetAvgDataZone']);


// code jacob 

Route::post("/data", [apiController::class, "postData"]);
Route::get("/water", [apiController::class, "getWater"]);

