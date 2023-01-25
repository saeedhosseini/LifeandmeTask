<?php

namespace App\Http\Middleware;

use App\Models\Admin\Admin;
use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
       if ($request->user() instanceof Admin){
           return $next($request);
       }else{
            return errorResponse(message: 'Unauthenticated' , status: 401);
       }

    }
}
