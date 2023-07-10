<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (!is_null($response)) {
            $response->header('Access-Control-Allow-Origin', '*')
                     ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                     ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }
        return $response;
    }
}

