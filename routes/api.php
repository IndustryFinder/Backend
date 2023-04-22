<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use \App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdController;
use \App\Http\Controllers\BookmarkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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
Route::get('/faker',[UserController::class, 'fakeAdder']);
Route::post('/user/signup', [UserController::class,'Register']);
Route::post('/user/login',[UserController::class,'Login']);
Route::post('/company/search', [CompanyController::class, 'index']);
Route::post('/ad/search', [AdController::class, 'index']);
Route::get('/Category', [CategoryController::class, 'index']);
Route::post('/company/show/{id}', [CompanyController::class, 'show']);
Route::get('/phpinfo', function() {
    return phpinfo();
});

//protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
	//*** User ***//
	Route::get('/user/logout',[UserController::class,'Logout']);
	Route::get('/user/this',[UserController::class,'loggedInUser']);
	Route::post('/user/changepass',[UserController::class,'ChangePass']);
	Route::post('/user/update',[UserController::class,'update']);
    Route::post('/user/Todoupdate',[UserController::class,'TodoUpdate']);
    Route::post('/user/Addcash',[UserController::class,'AddCash']);
    Route::post('/user/Withdraw',[UserController::class,'Withdraw']);
    Route::post('/user/GetBalance',[UserController::class,'GetBalance']);
	//*** Bookmark ***//
	Route::get('/user/bookmarks',[BookmarkController::class,'index']);
	Route::post('/user/bookmarks/add/{id}',[BookmarkController::class,'store']);
	Route::delete('/user/bookmarks/del/{id}',[BookmarkController::class,'destroy']);
    Route::get('/user/bookmarks/IsMarked/{id}', [BookmarkController::class, 'IsMarked']);
	//*** Ad ***//
    Route::get('/ad/searchByReceiver', [AdController::class, 'IndexByReceiver']);
    Route::get('/ad/searchBySender', [AdController::class, 'IndexBySender']);
    Route::get('/ad/show/{ad}', [AdController::class, 'show']);
	Route::post('/ad/makeAd', [AdController::class, 'makeAd']);
    Route::post('/ad/Update/{ad}', [AdController::class, 'update']);
	Route::post('/ad/accept', [AdController::class, 'Accept']);
	Route::delete('/ad/del/{ad}', [AdController::class, 'destroy']);
    //*** Category ***//
    Route::post('/Category/makeCategory', [CategoryController::class, 'makeCategory']);
    Route::delete('/Category/del/{category}', [CategoryController::class, 'delete']);
    Route::post('/Category/update/{category}', [CategoryController::class, 'update']);
	//*** Company ***//
	Route::post('/company/add', [CompanyController::class, 'store']);
	Route::post('/company/update/{id}', [CompanyController::class, 'update']);
	Route::delete('/company/delete/{id}', [CompanyController::class, 'destroy']);
	//*** Request ***//
    Route::post('/request/add', [RequestController::class, 'makeRequest']);
    Route::get('/request/accept/{id}', [RequestController::class, 'Accept']);
    Route::get('/request/reject/{id}', [RequestController::class, 'Reject']);
    Route::get('/Request/GetByUser/{User_id}', [RequestController::class, 'RequestsByUser']);
    Route::get('/Request/GetByAd/{Ad_id}', [RequestController::class, 'RequestsByAd']);
    Route::delete('/request/del/{id}', [RequestController::class, 'Destroy']);
  // Commit_&_rating
    Route::post('/Comment/Add', [\App\Http\Controllers\CommentController::class, 'make']);
    Route::delete('/Comment/Delete/{comment}', [\App\Http\Controllers\CommentController::class, 'delete']);
    Route::get('/Comment/GetByCompany/{id}', [\App\Http\Controllers\CommentController::class, 'getByCompany']);
   // Route::post('/Comment/update/{comment}', [\App\Http\Controllers\CommentController::class, 'update']);
    Route::get('/Comment/GetByUser/{id}', [\App\Http\Controllers\CommentController::class, 'getByUser']);
    //Route::post('/Comment/response/{comment}{response}', [\App\Http\Controllers\CommentController::class, 'response']);
    Route::get('/Comment/getAvgRate/{id}', [\App\Http\Controllers\CommentController::class, 'avgRating']);
});
