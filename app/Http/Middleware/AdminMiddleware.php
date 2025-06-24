<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !in_array($request->user()->role, ['teacher', 'admin'])) {
            return redirect()->route('lessons.index')->with('error', 'Access denied. Only teachers and admins can manage lessons.');
        }

        return $next($request);
    }
} 