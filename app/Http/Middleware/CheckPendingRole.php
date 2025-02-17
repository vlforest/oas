<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPendingRole
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->role == null || Auth::user()->role == 'Pending')) {
            return redirect()->route('pending.verification');
        }
        return $next($request);
    }
}
