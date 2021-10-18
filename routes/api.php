<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apiController;
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
    abort(404, 'API resource not found');
});

Route::post('login', [apiController::class, 'login']);

Route::middleware('auth:api')->group(function () {

});

Route::get("/test", function () {
    return "test";
});
