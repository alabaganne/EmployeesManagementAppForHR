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

Route::group([ 'middleware' => 'api', 'prefix' => 'auth' ], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group([ 'middleware' => 'auth:api', 'prefix' => 'collaborators', 'namespace' => 'Collaborators' ], function() {
    Route::middleware('can:view-collaborator')->group(function() {
        Route::post('/', 'CollaboratorController@index');
        Route::get('/{user}', 'CollaboratorController@show');
    });
    route::post('/create', 'CollaboratorController@store')->middleware('can:add-collaborator'); //? /api/collaborators/create
    Route::prefix('/{user}')->group(function() {
        Route::middleware('can:edit-collaborator')->group(function() {
            Route::put('/', 'CollaboratorController@update'); //? /api/collaborators/{user_id}

            Route::prefix('/trainings')->group(function() {
                Route::get('/', 'TrainingController@index');
                Route::post('/', 'TrainingController@store');
                Route::put('/{training}', 'TrainingController@update');
                Route::delete('/{training}', 'TrainingController@destroy');
            });
            
            Route::prefix('/skills')->group(function() {
                Route::get('/', 'SkillController@index'); //? /collaborators/{user_id}/skills
                Route::post('/', 'SkillController@store');
                Route::put('/{skill}', 'SkillController@update');
                Route::delete('/{skill}', 'SkillController@destroy');  //? /collaborators/{user_id}/skills/{skill_id}
            });
    
            Route::prefix('/evaluations')->group(function() {
                Route::get('/', 'EvaluationController@index');
                Route::post('/', 'EvaluationController@store');
                Route::put('/{evaluation}', 'EvaluationController@update');
                Route::delete('/{evaluation}', 'EvaluationController@destroy');
            });
    
            Route::prefix('leaves')->group(function() {
                Route::get('/', 'LeaveController@index');
                Route::post('/', 'LeaveController@store');
                Route::put('/{leave}', 'LeaveController@update');
                Route::delete('/{leave}', 'LeaveController@destroy');
            });
            
            Route::delete('/', 'CollaboratorController@destroy')->middleware('can:delete-collaborator');
        });
    });
});

Route::middleware('auth:api, can:edit-collaborator')->group(function() {
    // Data validation before adding data to table
    Route::namespace('Collaborators')->group(function() {
        Route::post('/validate/leave', 'LeaveController@isValid');
        Route::post('/validate/skill', 'SkillController@isValid');
        Route::post('/validate/training', 'TrainingController@isValid');
        Route::post('/validate/evaluation', 'EvaluationController@isValid');
    });
    // ?Manage departments
    Route::post('/departments', 'DepartmentController@store');
    Route::post('/departments/{department}', 'DepartmentController@getUsers');
    Route::delete('/departments/{department}', 'DepartmentController@destroy');
});

Route::get('/departments', 'DepartmentController@index')->middleware('auth:api');

Route::middleware('auth:api')->post('/account/update', 'UserController@update');