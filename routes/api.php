<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'Api\RegisterController@register');
Route::middleware('auth:api')->group( function () {
    Route::post('assign-promotion', 'Api\PromotionsCodesController@assign_promotion');
    Route::prefix('backoffice')->group(function () {
        Route::resource('promotion-codes', 'Api\PromotionsCodesController');
    });
});
