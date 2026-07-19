<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClienteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // no logueado
        if (!auth()->check()) {
            return redirect('/login');
        }

        // no es cliente
        if (auth()->user()->rol->nombre !== 'cliente') {
            abort(403);
        }

        return $next($request);
    }
}
