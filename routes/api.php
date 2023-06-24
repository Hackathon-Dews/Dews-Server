<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MachineLearningController;
use App\Http\Controllers\UserHistoryController;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(AuthenticationController::class)->group(function(){
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::get('/logout', 'logout')->middleware('auth:sanctum');
    Route::post('/change-password', 'changePassword')->middleware('auth:sanctum');
});

Route::group([
    'controller'    => UserHistoryController::class,
    'prefix'        => '/user-history',
], function () {
    Route::get('/', 'getUserHistory');
    Route::get('/{id}', 'getUserHistory');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', 'addUserHistory');
        Route::delete('/{id}', 'deleteUserHistory');
    });

});

Route::controller(UserHistoryController::class)->group(function(){
    Route::prefix('/user-history-by-user-id')->group(function(){
        Route::get('/{id}', 'getHistoryByUserId');
    });
});


Route::post('/predict', [MachineLearningController::class, 'prediction'])->middleware('auth:sanctum');
Route::post('/topic-modeling', [MachineLearningController::class, 'topicModeling'])->middleware('auth:sanctum');
Route::post('/summarize', [MachineLearningController::class, 'summarize'])->middleware('auth:sanctum');