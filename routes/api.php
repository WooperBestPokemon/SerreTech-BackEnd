<?php

use App\Http\Controllers\Auth\RegisterController;
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


//Unprotected Route
Route::post('/login', [apiController::class, 'login']);
Route::get('/greenHouse',[apiController::class, 'ViewGreenHouse']);
Route::get('/zone/{id}',[apiController::class,'ViewZone']);
Route::post("/data", [apiController::class, "postData"]);
Route::get("/water", [apiController::class, "getWater"]);

Route::fallback(function (){
    abort(response()->json('API resource not found',404));
});
