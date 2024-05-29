<?php

namespace App\Http\Middleware;

use Closure;

class SetHeaderToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the token is stored in the session
        if ($request->session()->has('access_token')) {
            $token = $request->session()->get('access_token');
            // Add the token to the request headers
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $next($request);
    }

}
