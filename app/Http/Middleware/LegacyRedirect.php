<?php

namespace App\Http\Middleware;

use App\Models\UrlRedirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Redirects legacy / old-website URLs to their current equivalents with a
 * single clean 301, so Google Search Console "Not found (404)" URLs recover
 * their link equity instead of dead-ending on the fallback route.
 *
 * Two sources, checked in order:
 *   1. Exact matches in the `url_redirects` table (also fed automatically when
 *      a content slug changes — see App\Traits\RecordsSlugRedirects).
 *   2. Pattern rules in config/legacy_redirects.php (old URL family -> listing).
 *
 * Registered in the `web` group BEFORE the locale middlewares so a locale-less
 * legacy URL emits one 301 rather than a 302 (locale add) -> 301 chain.
 */
class LegacyRedirect
{
    /** Cache key for the active exact-redirect map. */
    public const CACHE_KEY = 'url_redirects.map';

    /** Locales the site serves (matches config/laravellocalization.php). */
    protected array $locales = ['en', 'ar'];

    public function handle(Request $request, Closure $next): Response
    {
        // Only redirect safe, idempotent navigations.
        if (!$request->isMethod('GET') && !$request->isMethod('HEAD')) {
            return $next($request);
        }

        $path = trim($request->path(), '/'); // no host, no query, no leading/trailing slash

        if ($path === '' || $path === 'sitemap.xml' || $path === 'robots.txt') {
            return $next($request);
        }

        // Split off a leading locale segment, if present.
        $segments = explode('/', $path);
        $locale = in_array($segments[0], $this->locales, true) ? array_shift($segments) : 'en';
        $rest = implode('/', $segments); // locale-less path

        // 1) Exact match (full locale-prefixed path) from the url_redirects table.
        $map = $this->exactMap();
        if (isset($map[$path])) {
            [$to, $status] = $map[$path];
            if (ltrim($to, '/') !== $path) {
                // Fire-and-forget hit counter (exact rows only).
                DB::table('url_redirects')->where('from_path', $path)->increment('hits');
                return redirect()->to('/' . ltrim($to, '/'), $status);
            }
        }

        // 2) Pattern rules on the locale-less path -> nearest current listing.
        foreach (config('legacy_redirects', []) as $pattern => $target) {
            if (preg_match($pattern, $rest)) {
                $to = $locale . '/' . ltrim($target, '/');
                if ($to !== $path) {
                    return redirect()->to('/' . $to, 301);
                }
            }
        }

        return $next($request);
    }

    /**
     * The active exact-redirect map, cached. Shape: [from_path => [to_path, status_code]].
     * Cache is flushed by RecordsSlugRedirects when a new redirect is written.
     */
    protected function exactMap(): array
    {
        return Cache::remember(self::CACHE_KEY, now()->addHours(6), function () {
            return UrlRedirect::query()
                ->where('is_active', true)
                ->get(['from_path', 'to_path', 'status_code'])
                ->mapWithKeys(fn ($r) => [$r->from_path => [$r->to_path, $r->status_code]])
                ->all();
        });
    }
}
