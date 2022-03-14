<?php

use Illuminate\Http\Request;
use \App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::post('/user/register', [UserController::class,'Register']);

//protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user/logout',[UserController::class,'Logout']);
}
);
