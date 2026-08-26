<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EruApiToken
{
    private const TOKEN = 'c261a3feee62ba7c086f4bc7c6dd8e4ad1cfa2e446ab0326f86957d50509e5c5';

    public function handle(Request $request, Closure $next)
    {
        if (! hash_equals(self::TOKEN, (string) $request->bearerToken())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
