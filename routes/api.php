<?php

use App\Http\Controllers\Api\AccessKeyController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\QuestionController;
use Illuminate\Support\Facades\Route;

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    /* usuario */
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('customers/glasses', [CustomerController::class, 'setGlasses']);
    Route::post('customers/quiz', [CustomerController::class, 'newQuiz']);
    Route::post('customers/accesskey', [AccessKeyController::class, 'store']);
    
    Route::group(['middleware' => 'admin'], function () {
        Route::get('statistics', [AdminController::class, 'getStatistics']);
    
        Route::resource('questions', QuestionController::class)
                ->only(['index', 'show', 'store', 'update', 'destroy']);
    
        Route::resource('answers', AnswerController::class)
                ->only(['index', 'show', 'store', 'update', 'destroy']);
    });

});

