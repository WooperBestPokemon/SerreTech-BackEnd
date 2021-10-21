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

Route::get('/greenHouse',[apiController::class, 'ViewGreenHouse']);
Route::middleware('auth:api')->group(function () {

});
Route::get('/zone/{id}',[apiController::class,'ViewZone']);

Route::get("/test", function () {
    return "test";
});
