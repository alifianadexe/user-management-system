<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->ownership == 'admin' || Auth::check() && Auth::user()->ownership == 'owner' || Auth::check() && Auth::user()->status == 'active') {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
