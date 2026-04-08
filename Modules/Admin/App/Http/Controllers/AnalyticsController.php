<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Analytics\AnalyticsVisitor;
use App\Models\Analytics\AnalyticsSession;
use App\Models\Analytics\AnalyticsPageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    private const EXCLUDED_URL_PATTERNS = [
        '%/login%',
        '%/logout%',
        '%/checkuser%',
        '%/register%',
        '%/password/%',
        '%/admin',
        '%/admin/%',
        '%/basicdata',
        '%/basicdata/%',
        '%/crm',
        '%/crm/%',
        '%/search/live%',
        '%/search/emirates%',
        '%/search/categories%',
        '%/search/subcategories%',
        '%/search/types%',
        '%/search/styles%',
        '%/favourites/toggle%',
        '%/favourites/count%',
        '%/favourites/clear%',
        '%/favourites/send-email%',
        '%/home%',
    ];

    private function applyUrlFilter($query, string $urlColumn = 'url')
    {
        foreach (self::EXCLUDED_URL_PATTERNS as $pattern) {
            $query->where($urlColumn, 'NOT LIKE', $pattern);
        }
        return $query;
    }

    public function index(Request $request)
    {
        $range = $request->get('range', '30');
        $from = $request->get('from');
        $to = $request->get('to');

        if ($from && $to) {
            $startDate = Carbon::parse($from)->startOfDay();
            $endDate = Carbon::parse($to)->endOfDay();
        } else {
            $endDate = now()->endOfDay();
            $startDate = now()->subDays((int) $range)->startOfDay();
        }

        $kpis = $this->getKPIs($startDate, $endDate);
        $dailyChart = $this->getDailyChart($startDate, $endDate);
        $deviceData = $this->getDeviceData($startDate, $endDate);
        $topPages = $this->getTopPages($startDate, $endDate);
        $topReferrers = $this->getTopReferrers($startDate, $endDate);
        $countryData = $this->getCountryData($startDate, $endDate);
        $emirateData = $this->getEmirateData($startDate, $endDate);
        $browserData = $this->getBrowserData($startDate, $endDate);
        $osData = $this->getOSData($startDate, $endDate);
        $recentSessions = $this->getRecentSessions();

        return view('admin::analytics.index', compact(
            'kpis', 'dailyChart', 'deviceData', 'topPages',
            'topReferrers', 'countryData', 'emirateData',
            'browserData', 'osData', 'recentSessions',
            'startDate', 'endDate', 'range'
        ));
    }

    public function realtime()
    {
        $fiveMinAgo = now()->subMinutes(5);

        $baseQuery = AnalyticsPageView::where('viewed_at', '>=', $fiveMinAgo);
        $this->applyUrlFilter($baseQuery);

        $activeVisitors = (clone $baseQuery)->distinct('visitor_id')->count('visitor_id');

        $activePages = (clone $baseQuery)
            ->select('url', 'page_title', DB::raw('COUNT(*) as views'))
            ->groupBy('url', 'page_title')
            ->orderByDesc('views')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                return [
                    'url' => $p->url,
                    'title' => $p->page_title ?: basename(parse_url($p->url, PHP_URL_PATH) ?: '/'),
                    'views' => $p->views,
                ];
            });

        $countryQuery = AnalyticsPageView::where('analytics_page_views.viewed_at', '>=', $fiveMinAgo)
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->whereNotNull('analytics_visitors.country')
            ->select('analytics_visitors.country', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.country')
            ->orderByDesc('cnt')
            ->limit(5);
        $this->applyUrlFilter($countryQuery, 'analytics_page_views.url');
        $activeCountries = $countryQuery->pluck('cnt', 'country');

        return response()->json([
            'active_visitors' => $activeVisitors,
            'active_pages' => $activePages,
            'active_countries' => $activeCountries,
        ]);
    }

    public function visitors(Request $request)
    {
        $visitors = AnalyticsVisitor::orderByDesc('last_visit_at')
            ->paginate(50);

        return view('admin::analytics.visitors', compact('visitors'));
    }

    public function export(Request $request)
    {
        $from = $request->get('from', now()->subDays(30)->toDateString());
        $to = $request->get('to', now()->toDateString());

        $query = AnalyticsPageView::whereBetween('viewed_at', [$from, Carbon::parse($to)->endOfDay()])
            ->orderBy('viewed_at', 'desc');
        $this->applyUrlFilter($query);
        $views = $query->get();

        $csv = "ID,Visitor ID,Session ID,URL,Page Title,Route,Referrer,Time On Page,Viewed At\n";
        foreach ($views as $v) {
            $csv .= implode(',', [
                $v->id,
                $v->visitor_id,
                $v->session_id,
                '"' . str_replace('"', '""', $v->url) . '"',
                '"' . str_replace('"', '""', $v->page_title ?? '') . '"',
                $v->route_name ?? '',
                '"' . str_replace('"', '""', $v->referrer ?? '') . '"',
                $v->time_on_page ?? '',
                $v->viewed_at,
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="analytics_export_' . $from . '_' . $to . '.csv"',
        ]);
    }

    private function getKPIs(Carbon $start, Carbon $end): array
    {
        $viewsQuery = AnalyticsPageView::whereBetween('viewed_at', [$start, $end]);
        $this->applyUrlFilter($viewsQuery);

        $totalViews = (clone $viewsQuery)->count();
        $uniqueVisitors = (clone $viewsQuery)->distinct('visitor_id')->count('visitor_id');

        $validVisitorIds = (clone $viewsQuery)->distinct()->pluck('visitor_id');
        $sessionsQuery = AnalyticsSession::whereBetween('started_at', [$start, $end])
            ->whereIn('visitor_id', $validVisitorIds);

        $totalSessions = (clone $sessionsQuery)->count();
        $avgDuration = (clone $sessionsQuery)->avg('duration_seconds') ?? 0;
        $bounceRate = $totalSessions > 0
            ? round((clone $sessionsQuery)->where('is_bounce', true)->count() / $totalSessions * 100, 1)
            : 0;
        $pagesPerSession = $totalSessions > 0 ? round($totalViews / $totalSessions, 1) : 0;

        return [
            'total_views' => $totalViews,
            'unique_visitors' => $uniqueVisitors,
            'total_sessions' => $totalSessions,
            'avg_duration' => $avgDuration,
            'bounce_rate' => $bounceRate,
            'pages_per_session' => $pagesPerSession,
        ];
    }

    private function getDailyChart(Carbon $start, Carbon $end): array
    {
        $query = AnalyticsPageView::whereBetween('viewed_at', [$start, $end]);
        $this->applyUrlFilter($query);
        $views = $query->select(DB::raw('DATE(viewed_at) as date'), DB::raw('COUNT(*) as views'), DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $viewsData = [];
        $visitorsData = [];
        $current = $start->copy();

        while ($current->lte($end)) {
            $dateStr = $current->toDateString();
            $labels[] = $current->format('M d');
            $viewsData[] = $views->has($dateStr) ? $views[$dateStr]->views : 0;
            $visitorsData[] = $views->has($dateStr) ? $views[$dateStr]->visitors : 0;
            $current->addDay();
        }

        return ['labels' => $labels, 'views' => $viewsData, 'visitors' => $visitorsData];
    }

    private function getDeviceData(Carbon $start, Carbon $end): array
    {
        $query = AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->select('analytics_visitors.device_type', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.device_type');
        $this->applyUrlFilter($query, 'analytics_page_views.url');
        return $query->pluck('cnt', 'device_type')->toArray();
    }

    private function getTopPages(Carbon $start, Carbon $end)
    {
        $query = AnalyticsPageView::whereBetween('viewed_at', [$start, $end]);
        $this->applyUrlFilter($query);
        return $query->select('url', 'page_title', DB::raw('COUNT(*) as views'), DB::raw('COUNT(DISTINCT visitor_id) as unique_views'))
            ->groupBy('url', 'page_title')
            ->orderByDesc('views')
            ->limit(15)
            ->get();
    }

    private function getTopReferrers(Carbon $start, Carbon $end)
    {
        $query = AnalyticsPageView::whereBetween('viewed_at', [$start, $end])
            ->whereNotNull('referrer')
            ->where('referrer', 'NOT LIKE', '%' . request()->getHost() . '%');
        $this->applyUrlFilter($query);
        return $query->select(DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(referrer, '/', 3), '/', -1) as domain"), DB::raw('COUNT(*) as visits'))
            ->groupBy('domain')
            ->orderByDesc('visits')
            ->limit(10)
            ->get();
    }

    private function getCountryData(Carbon $start, Carbon $end): array
    {
        $query = AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->whereNotNull('analytics_visitors.country')
            ->select('analytics_visitors.country', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.country')
            ->orderByDesc('cnt')
            ->limit(10);
        $this->applyUrlFilter($query, 'analytics_page_views.url');
        return $query->pluck('cnt', 'country')->toArray();
    }

    private function getEmirateData(Carbon $start, Carbon $end): array
    {
        $query = AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->whereNotNull('analytics_visitors.emirate')
            ->select('analytics_visitors.emirate', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.emirate')
            ->orderByDesc('cnt');
        $this->applyUrlFilter($query, 'analytics_page_views.url');
        return $query->pluck('cnt', 'emirate')->toArray();
    }

    private function getBrowserData(Carbon $start, Carbon $end): array
    {
        $query = AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->select('analytics_visitors.browser', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.browser')
            ->orderByDesc('cnt');
        $this->applyUrlFilter($query, 'analytics_page_views.url');
        return $query->pluck('cnt', 'browser')->toArray();
    }

    private function getOSData(Carbon $start, Carbon $end): array
    {
        $query = AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->select('analytics_visitors.os', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.os')
            ->orderByDesc('cnt');
        $this->applyUrlFilter($query, 'analytics_page_views.url');
        return $query->pluck('cnt', 'os')->toArray();
    }

    private function getRecentSessions()
    {
        return AnalyticsSession::with(['visitor', 'pageViews' => function ($q) {
                $q->orderBy('viewed_at');
            }])
            ->orderByDesc('started_at')
            ->limit(20)
            ->get();
    }

    // ─── Data Cleanup ───────────────────────────────────────────────

    public function cleanupData()
    {
        $countries = AnalyticsVisitor::whereNotNull('country')
            ->select(
                'country',
                'country_code',
                DB::raw('COUNT(*) as visitors_count'),
                DB::raw('SUM(total_visits) as total_hits')
            )
            ->groupBy('country', 'country_code')
            ->orderByDesc('visitors_count')
            ->get();

        $internalUrls = AnalyticsPageView::where(function ($q) {
                foreach (self::EXCLUDED_URL_PATTERNS as $pattern) {
                    $q->orWhere('url', 'LIKE', $pattern);
                }
            })
            ->select('url', DB::raw('COUNT(*) as views_count'))
            ->groupBy('url')
            ->orderByDesc('views_count')
            ->get();

        $nullCountryVisitors = AnalyticsVisitor::whereNull('country')->count();

        $orphanedSessions = AnalyticsSession::whereNotIn(
            'visitor_id', AnalyticsPageView::select('visitor_id')->distinct()
        )->count();

        $orphanedVisitors = AnalyticsVisitor::whereNotIn(
            'visitor_id', AnalyticsPageView::select('visitor_id')->distinct()
        )->count();

        $totals = [
            'visitors' => AnalyticsVisitor::count(),
            'sessions' => AnalyticsSession::count(),
            'page_views' => AnalyticsPageView::count(),
        ];

        return response()->json([
            'countries' => $countries,
            'internal_urls' => $internalUrls,
            'null_country_visitors' => $nullCountryVisitors,
            'orphaned_sessions' => $orphanedSessions,
            'orphaned_visitors' => $orphanedVisitors,
            'totals' => $totals,
        ]);
    }

    public function destroyByCountry(Request $request)
    {
        $countries = $request->input('countries', []);
        if (empty($countries)) {
            return response()->json(['success' => false, 'message' => 'No countries selected.'], 422);
        }

        $visitorIds = AnalyticsVisitor::whereIn('country', $countries)->pluck('visitor_id');

        $deletedViews = AnalyticsPageView::whereIn('visitor_id', $visitorIds)->delete();
        $deletedSessions = AnalyticsSession::whereIn('visitor_id', $visitorIds)->delete();
        $deletedVisitors = AnalyticsVisitor::whereIn('country', $countries)->delete();

        return response()->json([
            'success' => true,
            'deleted' => [
                'visitors' => $deletedVisitors,
                'sessions' => $deletedSessions,
                'page_views' => $deletedViews,
            ],
            'message' => "Deleted {$deletedVisitors} visitors, {$deletedSessions} sessions, {$deletedViews} page views.",
        ]);
    }

    public function destroyByUrls(Request $request)
    {
        $urls = $request->input('urls', []);
        $cleanInternal = $request->boolean('clean_internal', false);

        $query = AnalyticsPageView::query();

        if ($cleanInternal) {
            $query->where(function ($q) {
                foreach (self::EXCLUDED_URL_PATTERNS as $pattern) {
                    $q->orWhere('url', 'LIKE', $pattern);
                }
            });
        } elseif (!empty($urls)) {
            $query->whereIn('url', $urls);
        } else {
            return response()->json(['success' => false, 'message' => 'No URLs selected.'], 422);
        }

        $deletedViews = $query->delete();

        return response()->json([
            'success' => true,
            'deleted' => ['page_views' => $deletedViews],
            'message' => "Deleted {$deletedViews} page views.",
        ]);
    }

    public function destroyOrphaned()
    {
        $deletedSessions = AnalyticsSession::whereNotIn(
            'visitor_id', AnalyticsPageView::select('visitor_id')->distinct()
        )->delete();

        $deletedVisitors = AnalyticsVisitor::whereNotIn(
            'visitor_id', AnalyticsPageView::select('visitor_id')->distinct()
        )->delete();

        return response()->json([
            'success' => true,
            'deleted' => [
                'sessions' => $deletedSessions,
                'visitors' => $deletedVisitors,
            ],
            'message' => "Deleted {$deletedSessions} orphaned sessions, {$deletedVisitors} orphaned visitors.",
        ]);
    }

    public function destroyNullCountry()
    {
        $visitorIds = AnalyticsVisitor::whereNull('country')->pluck('visitor_id');

        $deletedViews = AnalyticsPageView::whereIn('visitor_id', $visitorIds)->delete();
        $deletedSessions = AnalyticsSession::whereIn('visitor_id', $visitorIds)->delete();
        $deletedVisitors = AnalyticsVisitor::whereNull('country')->delete();

        return response()->json([
            'success' => true,
            'deleted' => [
                'visitors' => $deletedVisitors,
                'sessions' => $deletedSessions,
                'page_views' => $deletedViews,
            ],
            'message' => "Deleted {$deletedVisitors} visitors, {$deletedSessions} sessions, {$deletedViews} page views with unknown location.",
        ]);
    }
}
