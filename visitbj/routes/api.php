<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\PackController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\HotelController;



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
    Route::post('/send-reset-code', [AuthController::class,'send_reset_code']);
    Route::post('/verify-reset-code', [AuthController::class,'verify_reset_code']);
    Route::post('/reset-password', [AuthController::class,'reset_password']);
    Route::post('/generate-pin', [AuthController::class,'generatePin']);
    Route::post('/verify-pin', [AuthController::class,'verifyPin']);



});//end


Route::group(['prefix' => 'dashboard'], function () {

    Route::get('/packs', [PackController::class,'getPack']);
    Route::get('/events',  [ServiceController::class,'']);
    Route::post('/user-pack',  [ThemeController::class,'']);
    Route::post('/user-count',  [ThemeController::class,'']);

});//end



Route::group(['prefix' => 'admin'], function () {
    //login and register
    Route::post('/new-service', [ServiceController::class,'createService']);
    Route::get('/services',  [ServiceController::class,'getService']);
    Route::post('/new-theme',  [ThemeController::class,'createTheme']);
    Route::get('/themes',  [ThemeController::class,'getTheme']);
    Route::post('/new-pack', [PackController::class,'compositionPark']);
    Route::post('/new-media', [PackController::class,'addMediaToPack']);
    Route::post('/new-hotel', [HotelController::class,'addHotel']);
    Route::get('/hotels',  [ServiceController::class,'getService']);
});//end


Route::group(['prefix' => 'offer'], function () {
    Route::get('/services',  [ServiceController::class,'getService']);
    //theme
    Route::get('/themes',  [ThemeController::class,'getTheme']);
    //hotes
    Route::get('/hotels',  [HotelController::class,'getHotel']);
    Route::post('/personalized-pack', [PackController::class,'compositionPark']);
    Route::get('/packs', [PackController::class,'getPack']);
    Route::post('/detail-pack', [PackController::class,'detailPack']);
    Route::post('/search-pack-by-category', [PackController::class,'searchPackByTheme']);
    Route::post('/new-media', [PackController::class,'addMediaToPack']);
    Route::post('/user-reservation', [PackController::class,'reservationOfPack']);


});//end

