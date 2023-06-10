<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\PackController;
use App\Http\Controllers\Api\ActivityController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'auth'], function () {
    //login and register
    Route::post('/register-user', [AuthController::class,'registerUser']);
    Route::post('/login-user', [AuthController::class,'authenticateUser']);


});//end


Route::group(['prefix' => 'params'], function () {
    //login and register
    Route::post('/new-activity', [ActivityController::class,'createActivity']);
    Route::get('/activities',  [ActivityController::class,'getActivity']);
    Route::post('/new-city', [CityController::class,'createCity']);
    Route::get('/cities',  [CityController::class,'getCity']);
    Route::post('/new-event', [EventController::class,'createEvent']);
    Route::get('/events',  [EventController::class,'getEvent']);
    Route::post('/new-theme',  [ThemeController::class,'createTheme']);
    Route::get('/themes',  [ThemeController::class,'getTheme']);
    Route::post('/new-place',  [PlaceController::class,'createPlace']);
    Route::get('/places',  [PlaceController::class,'getPlace']);

});//end


Route::group(['prefix' => 'offer'], function () {
    //login and register
    Route::post('/new-pack', [PackController::class,'compositionPark']);
    Route::get('/packs', [PackController::class,'getPack']);
    Route::post('/detail-pack', [PackController::class,'detailPack']);
    Route::post('/search-pack-by-category', [PackController::class,'searchPackByTheme']);
    Route::post('/new-media', [PackController::class,'addMediaToPack']);
    Route::post('/user-reservation', [PackController::class,'reservationOfPack']);


});//end

