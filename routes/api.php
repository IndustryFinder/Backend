<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
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
Route::get('/ad/show/{ad}', [AdController::class, 'show']);
Route::post('/user/resetpass',[UserController::class, 'ResetPass']);
Route::get('/user/resetpass',[UserController::class, 'RecoverPass'])->name('password.reset');
Route::get('/faker',[UserController::class, 'fakeAdder']);
Route::post('/authentication/signup', [AuthController::class,'Register']);
Route::post('/authentication/login',[AuthController::class,'Login']);
Route::post('/user/submitnewpass',[UserController::class,'SubmitNewPass']);
Route::post('/company/search', [CompanyController::class, 'index']);
Route::post('/ad/search', [AdController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/category/show/{id}', [CategoryController::class, 'show']);
Route::get('/company/show/{company}', [CompanyController::class, 'show']);
Route::get('/company/user', [CompanyController::class, 'user']);
Route::get('/Comment/GetByCompany/{company}', [CommentController::class, 'getByCompany']);
Route::get('/Comment/getAvgRate/{id}', [CommentController::class, 'avgRating']);
Route::get('/phpinfo', function() {
    return phpinfo();
});

//protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //*** Authentication ***//
    Route::get('/authentication/this', [AuthController::class, 'loggedInUser']);
    Route::get('/authentication/logout',[AuthController::class,'Logout']);
	//*** User ***//
	Route::post('/user/changepass',[UserController::class,'ChangePass']);
	Route::post('/user/update',[UserController::class,'update']);
    Route::post('/user/Todoupdate',[UserController::class,'TodoUpdate']);
    Route::post('/user/Addcash',[UserController::class,'AddCash']);
    Route::post('/user/Withdraw',[UserController::class,'Withdraw']);
    Route::post('/user/GetBalance',[UserController::class,'GetBalance']);
    Route::get('/user/BuyPlan/{id}',[UserController::class,'BuyPlan']);
	//*** Bookmark ***//
	Route::get('/user/bookmarks',[BookmarkController::class,'index']);
	Route::post('/user/bookmarks/add',[BookmarkController::class,'store']);
	Route::delete('/user/bookmarks/del/{id}',[BookmarkController::class,'destroy']);
    Route::get('/user/bookmarks/IsMarked/{company}', [BookmarkController::class, 'IsMarked']);
	//*** Ad ***//
    Route::get('/ad/searchByReceiver', [AdController::class, 'IndexByReceiver']);
    Route::get('/ad/searchBySender', [AdController::class, 'IndexBySender']);
	Route::post('/ad/makeAd', [AdController::class, 'makeAd']);
    Route::post('/ad/Update/{ad}', [AdController::class, 'update']);
	Route::post('/ad/accept', [AdController::class, 'Accept']);
	Route::delete('/ad/del/{ad}', [AdController::class, 'destroy']);
    //*** Category ***//
    Route::post('/Category/makeCategory', [CategoryController::class, 'makeCategory']);
    Route::delete('/Category/del/{category}', [CategoryController::class, 'delete']);
   // Route::post('/Category/update/{category}', [CategoryController::class, 'update']);
	//*** Company ***//
	Route::post('/company/add', [CompanyController::class, 'store']);
	Route::post('/company/update/{id}', [CompanyController::class, 'update']);
	Route::delete('/company/delete/{id}', [CompanyController::class, 'destroy']);
	//*** Request ***//
    Route::post('/request/add', [RequestController::class, 'makeRequest']);
    Route::get('/request/accept/{request}', [RequestController::class, 'Accept']);
    Route::get('/request/reject/{request}', [RequestController::class, 'Reject']);
    Route::get('/Request/GetByUser/{user}', [RequestController::class, 'RequestsByUser']);
    Route::get('/Request/GetByAd/{ad}', [RequestController::class, 'RequestsByAd']);
    Route::get('/Request/GetByCompany/{id}', [RequestController::class, 'RequestsByCompany']);
    Route::delete('/request/del/{request}', [RequestController::class, 'Destroy']);
  // Commit_&_rating
    Route::post('/Comment/Add', [CommentController::class, 'make']);
    Route::delete('/Comment/Delete/{comment}', [CommentController::class, 'delete']);

   // Route::post('/Comment/update/{comment}', [\App\Http\Controllers\CommentController::class, 'update']);
    Route::get('/Comment/GetByUser/{id}', [CommentController::class, 'getByUser']);
    //Route::post('/Comment/response/{comment}{response}', [\App\Http\Controllers\CommentController::class, 'response']);

});
