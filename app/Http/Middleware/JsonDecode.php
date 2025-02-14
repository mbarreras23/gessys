<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonDecode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $property): Response
    {
        if ($request->has($property)) {
            $decoded_value = json_decode($request->$property, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $request->merge([$property => $decoded_value]);
            }
        }

        return $next($request);
    }
}
