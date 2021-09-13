<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApplicationSignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $header = 'X-Name')
    {
        $response = $next($request);
        // After Middleware :
        // After Middleware processes first and then returns the response
        // Usually Middleware directly call the next request
        $response->headers->set($header, config('app.name'));
        return $response;
    }
}
