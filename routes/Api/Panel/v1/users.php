<?php


use App\Http\Controllers\Panel\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {

    Route::get('' , [UserController::class , 'index']);
    Route::post('' , [UserController::class , 'store']);
    Route::put('{id}' , [UserController::class , 'update']);
    Route::delete('{id}' , [UserController::class , 'remove']);
});
