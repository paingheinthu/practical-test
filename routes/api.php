<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Survey\AnswerController;
use App\Http\Controllers\Survey\SurveyController;
use App\Http\Controllers\Survey\QuestionController;

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

Route::group(
    [
        'prefix' => 'v1',
    ],
    function () {
        //grouping of user related api
        Route::group(
            [
                'prefix' => '/user'
            ],
            function () {
                Route::resource('/register', UserController::class)->only(['store']);
                Route::post('/login', [UserController::class, 'login'])->name('login');
            }
        );

        //grouping of user related api
        Route::group(
            [
                'middleware' => 'auth:sanctum'
            ],

            function () {
                Route::resource('survey', SurveyController::class)->only(['store', 'show']);
                Route::put('survey/{id}/disable', [SurveyController::class, 'disable']);
                Route::post('survey/question/attach', [SurveyController::class, 'attachQuestion']);

                Route::resource('question', QuestionController::class)->only(['store']);

                Route::post('survey/answer', [AnswerController::class, 'store'])->middleware('send.mail');
            }
        );
    }
);
