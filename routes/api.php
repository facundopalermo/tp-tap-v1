<?php

use App\Http\Controllers\Api\AccessKeyController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\AttemptController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\QuestionController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    
    /* USUARIO */
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('customers/glasses', [CustomerController::class, 'setGlasses']);
    Route::get('customers/appointments', [CustomerController::class, 'getAppointment']);

    Route::get('customers/accesskey', [AccessKeyController::class, 'index']);
    Route::post('customers/accesskey', [AccessKeyController::class, 'store']);

    Route::get('customers/attempts', [AttemptController::class, 'index']);
    Route::post('customers/attempts', [AttemptController::class, 'newAttempt']);
    Route::get('customers/attempts/{attempt}', [AttemptController::class, 'getAttempt']);
    Route::post('customers/attempts/{id}', [AttemptController::class, 'answerQuiz']);
    
    /* ADMIN */
    Route::group(['middleware' => 'admin'], function () {
        Route::get('statistics', [AdminController::class, 'getStatistics']);
    
        Route::resource('questions', QuestionController::class)
                ->only(['index', 'show', 'store', 'update', 'destroy']);
    
        Route::resource('answers', AnswerController::class)
                ->only(['index', 'show', 'store', 'update', 'destroy']);
    });

});
