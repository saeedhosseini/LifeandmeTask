<?php

use App\Http\Controllers\Panel\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (){
        Route::post('login' , [AuthController::class , 'login']);
});
