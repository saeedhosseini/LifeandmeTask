<?php

use Illuminate\Support\Facades\Route;

Route::prefix('panel/v1')->group(function (){
    include __DIR__ . '/Panel/v1/auth.php';

  //  Route::middleware(['auth:sanctum'])->group(function (){
        include __DIR__ . '/Panel/v1/users.php';
  //  });

});

