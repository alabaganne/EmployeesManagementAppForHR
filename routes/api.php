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

Route::group([ 'middleware' => 'api', 'prefix' => 'auth' ], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group([ 'middleware' => 'auth:api', 'prefix' => 'collaborators', 'namespace' => 'Users' ], function($router) {
    Route::get('', 'CollaboratorsController@index');
    Route::post('', 'CollaboratorsController@store');
    Route::prefix('{user_id}')->group(function() {
        Route::get('', 'CollaboratorsController@show');
        Route::put('', 'CollaboratorsController@update');
        Route::delete('', 'CollaboratorsController@destroy');

        Route::prefix('skills')->group(function() {
            Route::get('', 'SkillsController@index');
            Route::post('', 'SkillsController@store');
            Route::prefix('{skill_id}')->group(function() {
                Route::put('', 'SkillsController@update');
                Route::delete('', 'SkillsController@destroy'); // /collaborators/{user_id}/skills/{skill_id}
            });
        });
        Route::prefix('trainings')->group(function() {
            Route::get('', 'TraningsController@index');
            Route::post('', 'TraningsController@store');
            Route::prefix('{training}')->group(function() {
                Route::put('', 'TraningsController@update');
                Route::delete('', 'TraningsController@destroy');
            });
        });
        Route::prefix('evaluations')->group(function() {
            Route::get('', 'EvaluationssController@index');
            Route::post('', 'EvaluationssController@store');
            Route::prefix('{evaluation}')->group(function() {
                Route::put('', 'EvaluationssController@update');
                Route::delete('', 'EvaluationssController@destroy');
            });
        });
        
        Route::prefix('leaves')->group(function() {
            Route::get('', 'LeavesController@index');
            Route::post('', 'LeavesController@store');
            Route::prefix('{leave}')->group(function() {
                Route::put('', 'LeavesController@update');
                Route::delete('', 'LeavesController@destroy');
            });
        });
    });
});