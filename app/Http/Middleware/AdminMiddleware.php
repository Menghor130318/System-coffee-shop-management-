<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        return redirect('/dashboard-customer');
    }
}