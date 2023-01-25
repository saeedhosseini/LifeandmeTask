<?php

namespace App\Http\Middleware;

use App\Models\User\User;
use Closure;
use Illuminate\Http\Request;
class UserAuth
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
       if ($request->user() == User::class){
           return $next($request);
       }else{
            return errorResponse(message: 'Unauthenticated' , status: 401);
       }

    }
}
