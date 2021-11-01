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
    Route::get('/GetGreenHouse',[apiController::class, 'ViewGreenHouses']);
});
Route::get('/zone/{id}',[apiController::class,'ViewZones']);

Route::get('/sensor/{id}',[apiController::class,'ViewSensors']);
Route::get("/test", function () {
    return "test";
});
