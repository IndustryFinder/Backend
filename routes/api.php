<?php

use Illuminate\Http\Request;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\BookmarkController;
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
Route::post('/user/login',[UserController::class,'Login']);

//protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user/logout',[UserController::class,'Logout']);
    Route::get('/user/bookmarks',[BookmarkController::class,'index']);
    Route::post('/user/bookmarks/add',[BookmarkController::class,'store']);
    Route::delete('/user/bookmarks/del',[BookmarkController::class,'destroy']);
});
