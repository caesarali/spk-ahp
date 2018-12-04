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

Route::namespace('API')->group(function () {
    Route::namespace('Master')->group(function () {
        Route::apiResource('criterias', 'CriteriaController')->except('show');
        Route::apiResource('alternatives', 'AlternativeController')->except('show');
    });

    Route::namespace('Analysis')->prefix('analysis')->group(function () {
        Route::get('criteria', 'CriteriaAnalysisController@index');
        Route::post('criteria', 'CriteriaAnalysisController@store');
    });
});
