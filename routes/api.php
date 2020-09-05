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

Route::group([ 'middleware' => 'auth:api', 'prefix' => 'collaborators', 'namespace' => 'Collaborators' ], function($router) {
    Route::get('/', 'CollaboratorController@index')->middleware('can:view-collaborator');
    route::post('/', 'CollaboratorController@store')->middleware('can:add-collaborator');
    Route::prefix('/{user}')->group(function($router) {
        Route::delete('/', 'CollaboratorController@destroy')->middleware('can:delete-collaborator');

        Route::middleware('can:edit-collaborator')->group(function($router) {
            Route::put('/', 'CollaboratorController@update');

            Route::prefix('/trainings')->group(function($router) {
                Route::get('/', 'TrainingController@index');
                Route::post('/', 'TrainingController@store');
                Route::put('/{training}', 'TrainingController@update');
                Route::delete('/{training}', 'TrainingController@destroy');
            });
            
            Route::prefix('/skills')->group(function($router) {
                Route::get('/', 'SkillController@index');
                Route::post('/', 'SkillController@store');
                Route::put('/{skill}', 'SkillController@update');
                Route::delete('/{skill}', 'SkillController@destroy');  // ? /collaborators/{collaborator_id}/skills/{skill_id}
            });
    
            Route::prefix('/evaluations')->group(function($router) {
                Route::get('/', 'EvaluationController@index');
                Route::post('/', 'EvaluationController@store');
                Route::put('/{evaluation}', 'EvaluationController@update');
                Route::delete('/{evaluation}', 'EvaluationController@destroy');
            });
    
            Route::prefix('leaves')->group(function($router) {
                Route::get('/', 'LeaveController@index');
                Route::post('/', 'LeaveController@store');
                Route::put('/{leave}', 'LeaveController@update');
                Route::delete('/{leave}', 'LeaveController@destroy');
            });
        });
    });
});

Route::get('/departments', 'DepartmentController@index');
Route::post('/departments', 'DepartmentController@store');
Route::post('/departments/{department}', 'DepartmentController@getUsers');
Route::delete('/departments/{department}', 'DepartmentController@destroy');