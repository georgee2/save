<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockHostingPaths
{
    /**
     * Blocked paths - cPanel and hosting related URLs
     */
    protected array $blockedPaths = [
        'cpanel',
        'webmail',
        'whm',
        '2082',
        '2083',
        '2086',
        '2087',
        'cpsess*',
        'cpses*',
        'webdisk',
        'autoconfig',
        'autodiscover',
        'cgi-bin',
        'cgi-sys',
        'phpmyadmin',
        'pma',
        'mysql',
        'myadmin',
        'server-status',
        'server-info',
        '.env',
        '.git',
        '.htaccess',
        'wp-admin',
        'wp-login',
        'wp-content',
        'administrator',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = strtolower($request->path());
        
        foreach ($this->blockedPaths as $blockedPath) {
            // Check if path starts with blocked path
            if (str_starts_with($path, $blockedPath) || 
                str_starts_with($path, '/' . $blockedPath) ||
                $request->is($blockedPath) ||
                $request->is($blockedPath . '/*') ||
                $request->is('*/' . $blockedPath) ||
                $request->is('*/' . $blockedPath . '/*')) {
                
                // Return 404 Not Found to hide the existence of these paths
                abort(404);
            }
        }
        
        // Also block requests with port numbers in the URL
        $blockedPorts = ['2082', '2083', '2086', '2087', '2095', '2096'];
        foreach ($blockedPorts as $port) {
            if (str_contains($request->getUri(), ':' . $port)) {
                abort(404);
            }
        }
        
        return $next($request);
    }
}
