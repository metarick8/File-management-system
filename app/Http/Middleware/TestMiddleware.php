<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        Log::channel('custom')->info('before processing request', ['url' => $request->fullUrl()]);
        // try {

        $response =  $next($request);
        // } catch (\Throwable $e) {
        // Log::error('Exception occurred', [
        //     'message' => $e->getMessage(),
        //     'exception' => $e,
        // ]);
        // throw $e;

        // Log::info('Exception occurred', ['message' => $e->getMessage()]);
        // return response()->json(['error' => 'An error occurred'], 500);
        // }
        // Log::info('After processing request', ['status' => $response->status()]);
        Log::channel('custom')->info('After proccessing request');



        return $response;
    }
}
