<?php

use App\Http\Controllers\User\UserController;
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

Route::group(
    [
        'prefix' => 'v1/',
    ],
    function () {
        //grouping of user related api
        Route::group(
            [
                'prefix' => 'user/',
                'namespace' => 'App\Http\Controllers\User'
            ],
            function () {
                Route::resource('register', UserController::class)->only(['store']);
                Route::post('login', [UserController::class, 'login']);
            }
        );

        // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        //     return $request->user();
        // });
    }
);
