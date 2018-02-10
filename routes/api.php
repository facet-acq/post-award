<?php

use Illuminate\Http\Request;

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

Route::group(['namespace' => 'Api'], function () {
    Route::group([
        'prefix' => 'v1',
        'namespace' => 'V1'
    ], function () {
        Route::post('notifications', 'SystemNotificationController@create');
        Route::group([
            'prefix' => 'interface',
            'namespace' => 'Edi'
        ], function () {
            Route::post('file', 'FileController@store');
            Route::get('file/{uuid}', 'FileController@show');
        });
    });
});
