<?php

namespace App\Http\Middleware;

use App\Http\Requests\FileInfoRequest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGroupMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $groupId = $request->route('group')->id;
        if (!$user->members()->where('groupId', $groupId)->exists())
            return response()->json(['error' => 'Unauthorized'], 403);
        return $next($request);
    }
}
