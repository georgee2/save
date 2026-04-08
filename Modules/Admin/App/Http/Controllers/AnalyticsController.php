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

        $activeVisitors = AnalyticsPageView::where('viewed_at', '>=', $fiveMinAgo)
            ->distinct('visitor_id')
            ->count('visitor_id');

        $activePages = AnalyticsPageView::where('viewed_at', '>=', $fiveMinAgo)
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

        $activeCountries = AnalyticsPageView::where('analytics_page_views.viewed_at', '>=', $fiveMinAgo)
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->whereNotNull('analytics_visitors.country')
            ->select('analytics_visitors.country', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.country')
            ->orderByDesc('cnt')
            ->limit(5)
            ->pluck('cnt', 'country');

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

        $views = AnalyticsPageView::whereBetween('viewed_at', [$from, Carbon::parse($to)->endOfDay()])
            ->orderBy('viewed_at', 'desc')
            ->get();

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
        $totalViews = AnalyticsPageView::whereBetween('viewed_at', [$start, $end])->count();
        $uniqueVisitors = AnalyticsPageView::whereBetween('viewed_at', [$start, $end])->distinct('visitor_id')->count('visitor_id');
        $totalSessions = AnalyticsSession::whereBetween('started_at', [$start, $end])->count();
        $avgDuration = AnalyticsSession::whereBetween('started_at', [$start, $end])->avg('duration_seconds') ?? 0;
        $bounceRate = $totalSessions > 0
            ? round(AnalyticsSession::whereBetween('started_at', [$start, $end])->where('is_bounce', true)->count() / $totalSessions * 100, 1)
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
        $views = AnalyticsPageView::whereBetween('viewed_at', [$start, $end])
            ->select(DB::raw('DATE(viewed_at) as date'), DB::raw('COUNT(*) as views'), DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
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
        return AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->select('analytics_visitors.device_type', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.device_type')
            ->pluck('cnt', 'device_type')
            ->toArray();
    }

    private function getTopPages(Carbon $start, Carbon $end)
    {
        return AnalyticsPageView::whereBetween('viewed_at', [$start, $end])
            ->select('url', 'page_title', DB::raw('COUNT(*) as views'), DB::raw('COUNT(DISTINCT visitor_id) as unique_views'))
            ->groupBy('url', 'page_title')
            ->orderByDesc('views')
            ->limit(15)
            ->get();
    }

    private function getTopReferrers(Carbon $start, Carbon $end)
    {
        return AnalyticsPageView::whereBetween('viewed_at', [$start, $end])
            ->whereNotNull('referrer')
            ->where('referrer', 'NOT LIKE', '%' . request()->getHost() . '%')
            ->select(DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(referrer, '/', 3), '/', -1) as domain"), DB::raw('COUNT(*) as visits'))
            ->groupBy('domain')
            ->orderByDesc('visits')
            ->limit(10)
            ->get();
    }

    private function getCountryData(Carbon $start, Carbon $end): array
    {
        return AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->whereNotNull('analytics_visitors.country')
            ->select('analytics_visitors.country', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.country')
            ->orderByDesc('cnt')
            ->limit(10)
            ->pluck('cnt', 'country')
            ->toArray();
    }

    private function getEmirateData(Carbon $start, Carbon $end): array
    {
        return AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->whereNotNull('analytics_visitors.emirate')
            ->select('analytics_visitors.emirate', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.emirate')
            ->orderByDesc('cnt')
            ->pluck('cnt', 'emirate')
            ->toArray();
    }

    private function getBrowserData(Carbon $start, Carbon $end): array
    {
        return AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->select('analytics_visitors.browser', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.browser')
            ->orderByDesc('cnt')
            ->pluck('cnt', 'browser')
            ->toArray();
    }

    private function getOSData(Carbon $start, Carbon $end): array
    {
        return AnalyticsPageView::whereBetween('analytics_page_views.viewed_at', [$start, $end])
            ->join('analytics_visitors', 'analytics_visitors.visitor_id', '=', 'analytics_page_views.visitor_id')
            ->select('analytics_visitors.os', DB::raw('COUNT(DISTINCT analytics_page_views.visitor_id) as cnt'))
            ->groupBy('analytics_visitors.os')
            ->orderByDesc('cnt')
            ->pluck('cnt', 'os')
            ->toArray();
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
}
