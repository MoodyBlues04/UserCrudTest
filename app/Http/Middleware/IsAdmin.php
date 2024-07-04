<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return Response|RedirectResponse|JsonResponse|null
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse|null
    {
        if (!$request->user() || !$request->user()->is_admin) {
            return $request->expectsJson()
                ? \response()->json(['ok' => false, 'message' => 'Not authorized for your role'])
                : null;
        }

        return $next($request);
    }
}
