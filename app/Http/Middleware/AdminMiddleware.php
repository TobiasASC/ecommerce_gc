<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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

            // logueado pero no admin
            if (auth()->user()->rol->nombre !== 'admin') {
                abort(403);
            }

            // admin válido
            return $next($request);
        }
}