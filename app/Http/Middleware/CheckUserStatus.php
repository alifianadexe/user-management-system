<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next, $status)
    {
        if (auth()->check() && auth()->user()->status == $status)
        {
            return $next($request);
        }

        return redirect('/');
    }
}
