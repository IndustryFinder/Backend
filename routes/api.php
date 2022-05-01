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

Route::post('/user/signup', [UserController::class,'Register']);
Route::post('/user/login',[UserController::class,'Login']);
Route::post('/Company/Get', [\App\Http\Controllers\CompanyController::class, 'index']);
Route::get('/Company/Get/{id}', [\App\Http\Controllers\CompanyController::class, 'show']);

//protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user/logout',[UserController::class,'Logout']);
    Route::get('/user/this',[UserController::class,'loggedInUser']);
    Route::post('/user/changepass',[UserController::class,'ChangePass']);
    Route::post('/user/update',[UserController::class,'update']);
    Route::get('/user/bookmarks',[BookmarkController::class,'index']);
    Route::post('/user/bookmarks/add/{id}',[BookmarkController::class,'store']);
    Route::delete('/user/bookmarks/del/{id}',[BookmarkController::class,'destroy']);
    Route::post('/ad/makead', [\App\Http\Controllers\AdController::class, 'makeAd']);
    Route::post('/company/add', [\App\Http\Controllers\CompanyController::class, 'store']);
    Route::post('/company/add', [\App\Http\Controllers\CompanyController::class, 'store']);
    Route::post('/company/add', [\App\Http\Controllers\CompanyController::class, 'store']);
    Route::post('/company/update/{id}', [\App\Http\Controllers\CompanyController::class, 'update']);
    Route::delete('/company/delete/{id}', [\App\Http\Controllers\CompanyController::class, 'destroy']);
    Route::post('/ad/accept', [\App\Http\Controllers\AdController::class, 'Accept']);
    Route::post('/request/add', [\App\Http\Controllers\RequestController::class, 'makeRequest']);
    Route::post('/request/accept', [\App\Http\Controllers\RequestController::class, 'Accept']);
    Route::post('/request/reject', [\App\Http\Controllers\RequestController::class, 'Reject']);

});
