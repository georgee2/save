<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomer
{
    /**
     * Ensure the authenticated user is a front-end customer account.
     * Staff accounts are redirected to their own dashboard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->isCustomer()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden.'], 403);
            }

            return redirect()->route('Admin')
                ->with('error', 'This area is restricted to customer accounts.');
        }

        return $next($request);
    }
}
