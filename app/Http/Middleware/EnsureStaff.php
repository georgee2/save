<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaff
{
    /**
     * Ensure the authenticated user is a back-office staff account.
     * Customer accounts must never reach the admin / CRM surface.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->isStaff()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden.'], 403);
            }

            return redirect()->route('account.dashboard')
                ->with('error', 'This area is restricted to staff accounts.');
        }

        return $next($request);
    }
}
