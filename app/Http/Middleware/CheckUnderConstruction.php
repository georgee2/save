<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUnderConstruction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ALWAYS allow access to admin routes (with or without locale prefix)
        // This must be checked FIRST before anything else
        if ($request->is('admin') || 
            $request->is('admin/*') || 
            $request->is('*/admin') || 
            $request->is('*/admin/*') ||
            $request->is('en/admin') ||
            $request->is('en/admin/*') ||
            $request->is('ar/admin') ||
            $request->is('ar/admin/*')) {
            return $next($request);
        }
        
        // ALWAYS allow access to login and authentication routes
        if ($request->is('login') || 
            $request->is('*/login') ||
            $request->is('en/login') ||
            $request->is('ar/login') ||
            $request->is('checkuser') ||
            $request->is('*/checkuser') ||
            $request->is('en/checkuser') ||
            $request->is('ar/checkuser') ||
            $request->is('logout') ||
            $request->is('*/logout')) {
            return $next($request);
        }
        
        // Check if under construction mode is enabled
        $underConstruction = config('site.under_construction', false);
        
        // Allow access if user is authenticated as admin
        if (auth()->check() && isset(auth()->user()->role) && auth()->user()->role === 'admin') {
            return $next($request);
        }
        
        // If under construction mode is enabled, show maintenance page
        if ($underConstruction) {
            return response()->view('under-construction', [], 503);
        }
        
        return $next($request);
    }
}

