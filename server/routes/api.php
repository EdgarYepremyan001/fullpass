<?php

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
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
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::post('forget', [PassportAuthController::class, 'forget']);
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [PassportAuthController::class,'logout']);
    Route::resource('posts', PostController::class);
    Route::resource('/admin',UsersController::class)->middleware('admin');
    Route::resource('/admin/posts/all',\App\Http\Controllers\Moderator\PostController::class)->middleware('admin');
    Route::resource('/moderator/posts',\App\Http\Controllers\Moderator\PostController::class)->middleware('moderator');
});


