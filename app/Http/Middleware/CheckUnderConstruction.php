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
        try {
            // ALWAYS allow access to backend modules (Admin, Basicdata, CRM)
            // This must be checked FIRST before anything else
            $backendPrefixes = ['admin', 'basicdata', 'crm'];
            
            foreach ($backendPrefixes as $prefix) {
                if ($request->is($prefix) || 
                    $request->is($prefix . '/*') || 
                    $request->is('*/' . $prefix) || 
                    $request->is('*/' . $prefix . '/*') ||
                    $request->is('en/' . $prefix) ||
                    $request->is('en/' . $prefix . '/*') ||
                    $request->is('ar/' . $prefix) ||
                    $request->is('ar/' . $prefix . '/*')) {
                    return $next($request);
                }
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
            
            // ALWAYS allow access to static assets
            if ($request->is('storage/*') || 
                $request->is('assets/*') ||
                $request->is('pic/*') ||
                $request->is('css/*') ||
                $request->is('js/*') ||
                $request->is('favicon.ico')) {
                return $next($request);
            }
            
            // Allow access to /home route for data entry staff (private access)
            // Also sets a session flag to allow browsing the entire site
            if ($request->is('home') || 
                $request->is('*/home') ||
                $request->is('en/home') ||
                $request->is('ar/home')) {
                // Set session flag to allow full site access
                session(['private_access' => true]);
                return $next($request);
            }
            
            // If user has private access via /home, allow all routes
            if (session('private_access') === true) {
                return $next($request);
            }
            
            // Check if under construction mode is enabled
            // Read directly from .env to avoid cache issues
            $underConstruction = $this->getUnderConstructionStatus();
            
            // If not under construction, skip all checks
            if (!$underConstruction) {
                return $next($request);
            }
            
            // Allow access if user is authenticated as admin
            try {
                if (auth()->check()) {
                    $user = auth()->user();
                    if ($user && isset($user->role) && $user->role === 'admin') {
                        return $next($request);
                    }
                }
            } catch (\Exception $e) {
                // If auth check fails, continue to show maintenance page
                \Log::warning('Auth check failed in under construction middleware: ' . $e->getMessage());
            }
            
            // Show maintenance page
            return response()->view('under-construction', [], 503);
            
            return $next($request);
        } catch (\Exception $e) {
            // If any error occurs, let the request through to avoid breaking the site
            \Log::error('CheckUnderConstruction middleware error: ' . $e->getMessage());
            return $next($request);
        }
    }
    
    /**
     * Get under construction status directly from .env file
     * This avoids config cache issues
     */
    private function getUnderConstructionStatus(): bool
    {
        try {
            // First try config (in case it's properly set)
            $configValue = config('site.under_construction');
            if ($configValue !== null) {
                return (bool) $configValue;
            }
            
            // Fallback: read directly from .env file
            $envPath = base_path('.env');
            if (file_exists($envPath)) {
                $envContent = file_get_contents($envPath);
                if (preg_match('/UNDER_CONSTRUCTION=(.*)/', $envContent, $matches)) {
                    return strtolower(trim($matches[1])) === 'true';
                }
            }
            
            return false;
        } catch (\Exception $e) {
            \Log::error('Error reading under construction status: ' . $e->getMessage());
            return false;
        }
    }
}

