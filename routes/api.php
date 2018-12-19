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
        Route::get('alternative/detail', 'AlternativeDetailController@index');
        Route::post('alternative/detail', 'AlternativeDetailController@add');
        Route::get('rating-scales', 'RatingScaleController@index');
    });

    Route::namespace('Analysis')->prefix('analysis')->group(function () {
        Route::namespace('Criteria')->prefix('criteria')->group(function() {
            Route::get('', 'CriteriaComparisonController@index');
            Route::post('', 'CriteriaComparisonController@store');
            Route::get('result', 'CriteriaAnalysisController@index');
            Route::post('result', 'CriteriaAnalysisController@result');
        });
        Route::namespace('Alternative')->prefix('alternative')->group(function() {
            Route::get('', 'AlternativeComparisonController@index');
            Route::post('', 'AlternativeComparisonController@store');
            Route::post('/{criteria}', 'AlternativeAnalysisController@analyze');
            Route::get('/{criteria}/result', 'AlternativeAnalysisController@result');
        });
        Route::get('result', 'ResultController@index');
        Route::get('result/by-alternative', 'ResultController@chartByAlternative');
    });
});
