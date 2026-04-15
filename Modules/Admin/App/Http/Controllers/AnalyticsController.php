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

    private function applyCountryFilter($query, array $countries, string $visitorIdColumn = 'visitor_id')
    {
        if (empty($countries)) return $query;
        $query->whereIn($visitorIdColumn, function ($sq) use ($countries) {
            $sq->select('visitor_id')->from('analytics_visitors')->whereIn('country', $countries);
        });
        return $query;
    }

    private function applyCountryFilterDirect($query, array $countries, string $countryColumn = 'analytics_visitors.country')
    {
        if (empty($countries)) return $query;
        $query->whereIn($countryColumn, $countries);
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

        $selectedCountries = array_filter((array) $request->get('countries', []));

        $allCountries = AnalyticsVisitor::whereNotNull('country')
            ->distinct()->orderBy('country')->pluck('country')->toArray();

        $kpis = $this->getKPIs($startDate, $endDate, $selectedCountries);
        $dailyChart = $this->getDailyChart($startDate, $endDate, $selectedCountries);
        $deviceData = $this->getDeviceData($startDate, $endDate, $selectedCountries);
        $topPages = $this->getTopPages($startDate, $endDate, $selectedCountries);
        $topReferrers = $this->getTopReferrers($startDate, $endDate, $selectedCountries);
        $countryData = $this->getCountryData($startDate, $endDate, $selectedCountries);
        $emirateData = $this->getEmirateData($startDate, $endDate, $selectedCountries);
        $browserData = $this->getBrowserData($startDate, $endDate, $selectedCountries);
        $osData = $this->getOSData($startDate, $endDate, $selectedCountries);
        $newVsReturning = $this->getNewVsReturning($startDate, $endDate, $selectedCountries);
        $entryExitPages = $this->getEntryExitPages($startDate, $endDate, $selectedCountries);
        $peakHours = $this->getPeakHours($startDate, $endDate, $selectedCountries);
        $journeyStats = $this->getJourneyStats($startDate, $endDate, $selectedCountries);

        return view('admin::analytics.index', compact(
            'kpis', 'dailyChart', 'deviceData', 'topPages',
            'topReferrers', 'countryData', 'emirateData',
            'browserData', 'osData', 'newVsReturning',
            'entryExitPages', 'peakHours', 'journeyStats',
            'allCountries', 'selectedCountries',
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

    private function getKPIs(Carbon $start, Carbon $end, array $countries = []): array
    {
        $viewsQuery = AnalyticsPageView::whereBetween('viewed_at', [$start, $end]);
        $this->applyUrlFilter($viewsQuery);
        $this->applyCountryFilter($viewsQuery, $countries);

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

    private function getDailyChart(Carbon $start, Carbon $end, array $countries = []): array
    {
        $query = AnalyticsPageView::whereBetween('viewed_at', [$start, $end]);
        $this->applyUrlFilter($query);
        $this->applyCountryFilter($query, $countries);
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

    private function getDeviceData(Carbon $start, Carbon $end, array $countries = []): array
    {
        $query = AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->select('analytics_visitors.device_type', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.device_type');
        $this->applyUrlFilter($query, 'analytics_page_views.url');
        $this->applyCountryFilterDirect($query, $countries);
        return $query->pluck('cnt', 'device_type')->toArray();
    }

    private function getTopPages(Carbon $start, Carbon $end, array $countries = [])
    {
        $query = AnalyticsPageView::whereBetween('viewed_at', [$start, $end]);
        $this->applyUrlFilter($query);
        $this->applyCountryFilter($query, $countries);
        return $query->select('url', 'page_title', DB::raw('COUNT(*) as views'), DB::raw('COUNT(DISTINCT visitor_id) as unique_views'))
            ->groupBy('url', 'page_title')
            ->orderByDesc('views')
            ->limit(15)
            ->get();
    }

    private function getTopReferrers(Carbon $start, Carbon $end, array $countries = [])
    {
        $query = AnalyticsPageView::whereBetween('viewed_at', [$start, $end])
            ->whereNotNull('referrer')
            ->where('referrer', 'NOT LIKE', '%' . request()->getHost() . '%');
        $this->applyUrlFilter($query);
        $this->applyCountryFilter($query, $countries);
        return $query->select(DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(referrer, '/', 3), '/', -1) as domain"), DB::raw('COUNT(*) as visits'))
            ->groupBy('domain')
            ->orderByDesc('visits')
            ->limit(10)
            ->get();
    }

    private function getCountryData(Carbon $start, Carbon $end, array $countries = []): array
    {
        $query = AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->whereNotNull('analytics_visitors.country')
            ->select('analytics_visitors.country', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.country')
            ->orderByDesc('cnt')
            ->limit(10);
        $this->applyUrlFilter($query, 'analytics_page_views.url');
        $this->applyCountryFilterDirect($query, $countries);
        return $query->pluck('cnt', 'country')->toArray();
    }

    private function getEmirateData(Carbon $start, Carbon $end, array $countries = []): array
    {
        $query = AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->whereNotNull('analytics_visitors.emirate')
            ->select('analytics_visitors.emirate', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.emirate')
            ->orderByDesc('cnt');
        $this->applyUrlFilter($query, 'analytics_page_views.url');
        $this->applyCountryFilterDirect($query, $countries);
        return $query->pluck('cnt', 'emirate')->toArray();
    }

    private function getBrowserData(Carbon $start, Carbon $end, array $countries = []): array
    {
        $query = AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->select('analytics_visitors.browser', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.browser')
            ->orderByDesc('cnt');
        $this->applyUrlFilter($query, 'analytics_page_views.url');
        $this->applyCountryFilterDirect($query, $countries);
        return $query->pluck('cnt', 'browser')->toArray();
    }

    private function getOSData(Carbon $start, Carbon $end, array $countries = []): array
    {
        $query = AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->select('analytics_visitors.os', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.os')
            ->orderByDesc('cnt');
        $this->applyUrlFilter($query, 'analytics_page_views.url');
        $this->applyCountryFilterDirect($query, $countries);
        return $query->pluck('cnt', 'os')->toArray();
    }

    private function getNewVsReturning(Carbon $start, Carbon $end, array $countries = []): array
    {
        $viewsQuery = AnalyticsPageView::whereBetween('viewed_at', [$start, $end]);
        $this->applyUrlFilter($viewsQuery);
        $this->applyCountryFilter($viewsQuery, $countries);
        $activeVisitorIds = (clone $viewsQuery)->distinct()->pluck('visitor_id');

        if ($activeVisitorIds->isEmpty()) {
            return ['new' => 0, 'returning' => 0];
        }

        $newCount = AnalyticsVisitor::whereIn('visitor_id', $activeVisitorIds)
            ->whereBetween('first_visit_at', [$start, $end])
            ->count();

        $returningCount = AnalyticsVisitor::whereIn('visitor_id', $activeVisitorIds)
            ->where('first_visit_at', '<', $start)
            ->count();

        return ['new' => $newCount, 'returning' => $returningCount];
    }

    private function getEntryExitPages(Carbon $start, Carbon $end, array $countries = []): array
    {
        $viewsQuery = AnalyticsPageView::whereBetween('viewed_at', [$start, $end]);
        $this->applyUrlFilter($viewsQuery);
        $this->applyCountryFilter($viewsQuery, $countries);
        $validVisitorIds = (clone $viewsQuery)->distinct()->pluck('visitor_id');

        $sessionsBase = AnalyticsSession::whereBetween('started_at', [$start, $end])
            ->whereIn('visitor_id', $validVisitorIds);

        $entryPages = (clone $sessionsBase)
            ->select('entry_page', DB::raw('COUNT(*) as cnt'))
            ->groupBy('entry_page')
            ->orderByDesc('cnt')
            ->limit(10)
            ->get();

        $exitPages = (clone $sessionsBase)
            ->select('exit_page', DB::raw('COUNT(*) as cnt'))
            ->groupBy('exit_page')
            ->orderByDesc('cnt')
            ->limit(10)
            ->get();

        return ['entry' => $entryPages, 'exit' => $exitPages];
    }

    private function getPeakHours(Carbon $start, Carbon $end, array $countries = []): array
    {
        $query = AnalyticsPageView::whereBetween('viewed_at', [$start, $end]);
        $this->applyUrlFilter($query);
        $this->applyCountryFilter($query, $countries);

        $rows = $query->select(
                DB::raw('DAYOFWEEK(viewed_at) as dow'),
                DB::raw('HOUR(viewed_at) as hour'),
                DB::raw('COUNT(*) as views')
            )
            ->groupBy('dow', 'hour')
            ->get();

        $grid = [];
        $maxVal = 0;
        foreach ($rows as $r) {
            $grid[$r->dow][$r->hour] = $r->views;
            if ($r->views > $maxVal) $maxVal = $r->views;
        }

        return ['grid' => $grid, 'max' => $maxVal];
    }

    private function getJourneyStats(Carbon $start, Carbon $end, array $countries = []): array
    {
        $viewsQuery = AnalyticsPageView::whereBetween('viewed_at', [$start, $end]);
        $this->applyUrlFilter($viewsQuery);
        $this->applyCountryFilter($viewsQuery, $countries);
        $validVisitorIds = (clone $viewsQuery)->distinct()->pluck('visitor_id');

        $sessionsBase = AnalyticsSession::whereBetween('started_at', [$start, $end])
            ->whereIn('visitor_id', $validVisitorIds);

        $totalSessions = (clone $sessionsBase)->count();
        $avgPages = (clone $sessionsBase)->avg('page_count') ?? 0;
        $avgDuration = (clone $sessionsBase)->avg('duration_seconds') ?? 0;
        $bounces = $totalSessions > 0
            ? round((clone $sessionsBase)->where('is_bounce', true)->count() / $totalSessions * 100, 1)
            : 0;

        $topEntry = (clone $sessionsBase)
            ->select('entry_page', DB::raw('COUNT(*) as cnt'))
            ->groupBy('entry_page')
            ->orderByDesc('cnt')
            ->first();

        $topExit = (clone $sessionsBase)
            ->select('exit_page', DB::raw('COUNT(*) as cnt'))
            ->groupBy('exit_page')
            ->orderByDesc('cnt')
            ->first();

        return [
            'avg_pages' => round($avgPages, 1),
            'avg_duration' => (int) $avgDuration,
            'bounce_rate' => $bounces,
            'top_entry' => $topEntry ? parse_url($topEntry->entry_page, PHP_URL_PATH) ?: '/' : '-',
            'top_exit' => $topExit ? parse_url($topExit->exit_page, PHP_URL_PATH) ?: '/' : '-',
        ];
    }

    // ─── Journey AJAX endpoint ──────────────────────────────────────

    public function getFilteredJourneys(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $countries = array_filter((array) $request->get('countries', []));
        $device = $request->get('device');
        $search = $request->get('search');
        $perPage = (int) $request->get('per_page', 15);

        $start = $from ? Carbon::parse($from)->startOfDay() : now()->subDays(30)->startOfDay();
        $end = $to ? Carbon::parse($to)->endOfDay() : now()->endOfDay();

        $query = AnalyticsSession::with(['visitor', 'pageViews' => function ($q) {
                $q->orderBy('viewed_at');
            }])
            ->whereBetween('started_at', [$start, $end])
            ->orderByDesc('started_at');

        if (!empty($countries)) {
            $query->whereHas('visitor', fn($q) => $q->whereIn('country', $countries));
        }
        if ($device) {
            $query->whereHas('visitor', fn($q) => $q->where('device_type', $device));
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('entry_page', 'LIKE', "%{$search}%")
                  ->orWhere('exit_page', 'LIKE', "%{$search}%");
            });
        }

        $paginated = $query->paginate($perPage);

        $items = $paginated->getCollection()->map(function ($sess) {
            return [
                'id' => $sess->id,
                'visitor_id' => $sess->visitor_id,
                'country' => $sess->visitor->country ?? null,
                'device' => $sess->visitor->device_type ?? 'desktop',
                'browser' => $sess->visitor->browser ?? null,
                'ip' => $sess->visitor->ip_address ?? null,
                'entry_page' => $sess->entry_page,
                'exit_page' => $sess->exit_page,
                'page_count' => $sess->page_count,
                'duration' => $sess->duration_seconds,
                'is_bounce' => $sess->is_bounce,
                'started_at' => $sess->started_at ? $sess->started_at->format('M d, H:i') : '-',
                'pages' => $sess->pageViews->map(function ($pv) {
                    return [
                        'url' => $pv->url,
                        'path' => parse_url($pv->url, PHP_URL_PATH) ?: '/',
                        'title' => $pv->page_title,
                        'time_on_page' => $pv->time_on_page,
                        'referrer' => $pv->referrer,
                        'viewed_at' => $pv->viewed_at ? $pv->viewed_at->format('H:i:s') : null,
                    ];
                }),
            ];
        });

        return response()->json([
            'data' => $items,
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'total' => $paginated->total(),
            'per_page' => $paginated->perPage(),
        ]);
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
