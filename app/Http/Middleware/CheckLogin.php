<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->code !== 'A') {
            return redirect()->route('login.test')
                ->with('error', 'you put the wrong password');
        }

        return $next($request);
    }
}