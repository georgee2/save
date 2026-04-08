<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\Analytics\AnalyticsVisitor;
use App\Models\Analytics\AnalyticsSession;
use App\Models\Analytics\AnalyticsPageView;
use Stevebauman\Location\Facades\Location;

class TrackPageView
{
    private const SESSION_TIMEOUT = 1800; // 30 minutes
    private const COOKIE_NAME = 'svec_vid';
    private const COOKIE_LIFETIME = 1051200; // 2 years in minutes

    private const BOT_PATTERNS = [
        'bot', 'crawl', 'spider', 'slurp', 'mediapartners', 'Googlebot',
        'Bingbot', 'BingPreview', 'Yahoo', 'Baidu', 'YandexBot', 'DuckDuckBot',
        'Sogou', 'Exabot', 'facebot', 'ia_archiver', 'MJ12bot', 'AhrefsBot',
        'SemrushBot', 'DotBot', 'rogerbot', 'Screaming Frog', 'GTmetrix',
        'Pingdom', 'UptimeRobot', 'curl', 'wget', 'python-requests',
        'Go-http-client', 'Apache-HttpClient', 'Java/', 'libwww-perl',
        'Scrapy', 'PhantomJS', 'HeadlessChrome', 'Lighthouse',
        'PageSpeed', 'Google-Read-Aloud', 'APIs-Google', 'Mediapartners-Google',
        'AdsBot-Google', 'Googlebot-Image', 'Googlebot-Video', 'Googlebot-News',
        'Chrome-Lighthouse', 'PTST', 'Bytespider', 'PetalBot', 'CCBot',
        'DataForSeoBot', 'GPTBot', 'ClaudeBot', 'anthropic-ai',
    ];

    private const INTERNAL_PATHS = [
        'login', 'logout', 'checkuser', 'register', 'password/*',
        '*/login', '*/logout', '*/checkuser', '*/register', '*/password/*',
        'search/live', 'search/emirates', 'search/categories',
        'search/subcategories', 'search/types', 'search/styles',
        '*/search/live', '*/search/emirates', '*/search/categories',
        '*/search/subcategories', '*/search/types', '*/search/styles',
        'favourites/toggle', 'favourites/count', 'favourites/clear/*',
        'favourites/send-email',
        '*/favourites/toggle', '*/favourites/count', '*/favourites/clear/*',
        '*/favourites/send-email',
        'home',
        '*/home',
    ];

    private const EMIRATE_MAP = [
        'dubai' => 'Dubai',
        'abu dhabi' => 'Abu Dhabi',
        'sharjah' => 'Sharjah',
        'ajman' => 'Ajman',
        'ras al khaimah' => 'Ras Al Khaimah',
        'ras al-khaimah' => 'Ras Al Khaimah',
        'fujairah' => 'Fujairah',
        'al fujairah' => 'Fujairah',
        'umm al quwain' => 'Umm Al Quwain',
        'umm al-quwain' => 'Umm Al Quwain',
        'al ain' => 'Abu Dhabi',
    ];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->shouldSkip($request, $response)) {
            return $response;
        }

        try {
            $visitorId = $this->getOrCreateVisitorId($request);
            $visitor = $this->upsertVisitor($request, $visitorId);
            $session = $this->resolveSession($visitor, $request);
            $this->recordPageView($session, $visitor, $request);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Analytics tracking error: ' . $e->getMessage());
        }

        return $response;
    }

    private function shouldSkip(Request $request, $response): bool
    {
        if (!$request->isMethod('GET')) return true;
        if ($request->ajax() || $request->wantsJson()) return true;

        // Only track successful HTML page responses (not 404, 500, redirects)
        $statusCode = method_exists($response, 'getStatusCode') ? $response->getStatusCode() : 200;
        if ($statusCode !== 200) return true;

        // Skip backend/admin paths (with and without trailing content)
        if ($request->is('admin', 'admin/*', 'basicdata', 'basicdata/*', 'crm', 'crm/*', 'api/*', 'analytics/*', 'sitemap*', 'storage/*')) return true;
        if ($request->is('*/admin', '*/admin/*', '*/basicdata', '*/basicdata/*', '*/crm', '*/crm/*')) return true;

        // Skip internal/auth pages
        if ($request->is(...self::INTERNAL_PATHS)) return true;

        // Skip static assets
        if ($request->is('*.js', '*.css', '*.png', '*.jpg', '*.svg', '*.ico', '*.webp', '*.woff*', '*.ttf')) return true;
        if (str_contains($request->header('Content-Type', ''), 'application/json')) return true;

        // Skip bots and crawlers
        if ($this->isBot($request->userAgent() ?? '')) return true;

        return false;
    }

    private function isBot(string $ua): bool
    {
        if (empty($ua) || strlen($ua) < 10) return true;

        $uaLower = strtolower($ua);
        foreach (self::BOT_PATTERNS as $pattern) {
            if (str_contains($uaLower, strtolower($pattern))) {
                return true;
            }
        }

        return false;
    }

    private function getOrCreateVisitorId(Request $request): string
    {
        $visitorId = $request->cookie(self::COOKIE_NAME);

        if (!$visitorId) {
            $visitorId = (string) Str::uuid();
            Cookie::queue(self::COOKIE_NAME, $visitorId, self::COOKIE_LIFETIME);
        }

        return $visitorId;
    }

    private function upsertVisitor(Request $request, string $visitorId): AnalyticsVisitor
    {
        $visitor = AnalyticsVisitor::where('visitor_id', $visitorId)->first();

        if ($visitor) {
            $visitor->update([
                'last_visit_at' => now(),
                'total_visits' => $visitor->total_visits + 1,
            ]);
            return $visitor;
        }

        $ua = $request->userAgent() ?? '';
        $ip = $request->ip();
        $geo = $this->resolveGeo($ip);

        return AnalyticsVisitor::create([
            'visitor_id' => $visitorId,
            'ip_address' => $ip,
            'country' => $geo['country'],
            'country_code' => $geo['country_code'],
            'city' => $geo['city'],
            'emirate' => $geo['emirate'],
            'device_type' => $this->detectDevice($ua),
            'browser' => $this->detectBrowser($ua),
            'os' => $this->detectOS($ua),
            'first_visit_at' => now(),
            'last_visit_at' => now(),
            'total_visits' => 1,
        ]);
    }

    private function resolveGeo(string $ip): array
    {
        $default = ['country' => null, 'country_code' => null, 'city' => null, 'emirate' => null];

        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            return $default;
        }

        return Cache::remember("geo_{$ip}", 86400, function () use ($ip, $default) {
            try {
                $position = Location::get($ip);
                if (!$position) return $default;

                $city = $position->cityName ?? null;
                $emirate = null;
                if ($city && ($position->countryCode ?? '') === 'AE') {
                    $emirate = self::EMIRATE_MAP[strtolower(trim($city))] ?? null;
                }

                return [
                    'country' => $position->countryName ?? null,
                    'country_code' => $position->countryCode ?? null,
                    'city' => $city,
                    'emirate' => $emirate,
                ];
            } catch (\Throwable $e) {
                return $default;
            }
        });
    }

    private function resolveSession(AnalyticsVisitor $visitor, Request $request): AnalyticsSession
    {
        $currentSession = AnalyticsSession::where('visitor_id', $visitor->visitor_id)
            ->where('ended_at', '>=', now()->subSeconds(self::SESSION_TIMEOUT))
            ->orderBy('ended_at', 'desc')
            ->first();

        if ($currentSession) {
            return $currentSession;
        }

        return AnalyticsSession::create([
            'session_id' => (string) Str::uuid(),
            'visitor_id' => $visitor->visitor_id,
            'ip_address' => $request->ip(),
            'entry_page' => $request->fullUrl(),
            'exit_page' => $request->fullUrl(),
            'page_count' => 0,
            'duration_seconds' => 0,
            'started_at' => now(),
            'ended_at' => now(),
            'is_bounce' => true,
        ]);
    }

    private function recordPageView(AnalyticsSession $session, AnalyticsVisitor $visitor, Request $request): void
    {
        AnalyticsPageView::create([
            'session_id' => $session->session_id,
            'visitor_id' => $visitor->visitor_id,
            'url' => $request->fullUrl(),
            'page_title' => null,
            'route_name' => $request->route()?->getName(),
            'referrer' => $request->header('referer'),
            'viewed_at' => now(),
        ]);

        $newCount = $session->page_count + 1;
        $duration = $session->started_at ? now()->diffInSeconds($session->started_at) : 0;

        $session->update([
            'exit_page' => $request->fullUrl(),
            'page_count' => $newCount,
            'duration_seconds' => $duration,
            'ended_at' => now(),
            'is_bounce' => $newCount <= 1,
        ]);
    }

    private function detectDevice(string $ua): string
    {
        if (preg_match('/tablet|ipad|playbook|silk/i', $ua)) return 'tablet';
        if (preg_match('/mobile|iphone|ipod|android.*mobile|windows phone|blackberry/i', $ua)) return 'mobile';
        return 'desktop';
    }

    private function detectBrowser(string $ua): string
    {
        if (preg_match('/Edg/i', $ua)) return 'Edge';
        if (preg_match('/OPR|Opera/i', $ua)) return 'Opera';
        if (preg_match('/Chrome/i', $ua) && !preg_match('/Edg|OPR/i', $ua)) return 'Chrome';
        if (preg_match('/Firefox/i', $ua)) return 'Firefox';
        if (preg_match('/Safari/i', $ua) && !preg_match('/Chrome/i', $ua)) return 'Safari';
        if (preg_match('/MSIE|Trident/i', $ua)) return 'IE';
        return 'Other';
    }

    private function detectOS(string $ua): string
    {
        if (preg_match('/Windows/i', $ua)) return 'Windows';
        if (preg_match('/Macintosh|Mac OS/i', $ua)) return 'macOS';
        if (preg_match('/Linux/i', $ua) && !preg_match('/Android/i', $ua)) return 'Linux';
        if (preg_match('/Android/i', $ua)) return 'Android';
        if (preg_match('/iPhone|iPad|iPod/i', $ua)) return 'iOS';
        return 'Other';
    }
}
