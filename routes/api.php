<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MachineLearningController;
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

Route::post('/predict', [MachineLearningController::class, 'prediction']);
Route::post('/topic-modeling', [MachineLearningController::class, 'topicModeling']);
Route::post('/summarize', [MachineLearningController::class, 'summarize']);