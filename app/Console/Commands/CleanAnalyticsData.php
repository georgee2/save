<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Analytics\AnalyticsPageView;
use App\Models\Analytics\AnalyticsSession;
use App\Models\Analytics\AnalyticsVisitor;

class CleanAnalyticsData extends Command
{
    protected $signature = 'analytics:clean {--dry-run : Show what would be deleted without actually deleting}';
    protected $description = 'Remove page views for internal/backend URLs and orphaned visitors from analytics data';

    private const INTERNAL_PATTERNS = [
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

    public function handle()
    {
        $dryRun = $this->option('dry-run');

        $query = AnalyticsPageView::query();
        $query->where(function ($q) {
            foreach (self::INTERNAL_PATTERNS as $pattern) {
                $q->orWhere('url', 'LIKE', $pattern);
            }
        });

        $count = $query->count();
        $this->info("Found {$count} page views for internal/backend URLs.");

        if ($dryRun) {
            $query->select('url')
                ->groupBy('url')
                ->get()
                ->each(fn ($row) => $this->line("  - {$row->url}"));
            $this->warn('Dry run complete. No data was deleted.');
            return 0;
        }

        if ($count === 0) {
            $this->info('Nothing to clean.');
            return 0;
        }

        if (!$this->confirm("Delete {$count} internal page views?")) {
            return 0;
        }

        $deleted = $query->delete();
        $this->info("Deleted {$deleted} internal page views.");

        $orphanedSessions = AnalyticsSession::whereNotIn(
            'session_id',
            AnalyticsPageView::select('session_id')->distinct()
        )->count();

        if ($orphanedSessions > 0 && $this->confirm("Delete {$orphanedSessions} orphaned sessions?")) {
            AnalyticsSession::whereNotIn(
                'session_id',
                AnalyticsPageView::select('session_id')->distinct()
            )->delete();
            $this->info("Deleted {$orphanedSessions} orphaned sessions.");
        }

        $orphanedVisitors = AnalyticsVisitor::whereNotIn(
            'visitor_id',
            AnalyticsPageView::select('visitor_id')->distinct()
        )->count();

        if ($orphanedVisitors > 0 && $this->confirm("Delete {$orphanedVisitors} orphaned visitors (no remaining page views)?")) {
            AnalyticsVisitor::whereNotIn(
                'visitor_id',
                AnalyticsPageView::select('visitor_id')->distinct()
            )->delete();
            $this->info("Deleted {$orphanedVisitors} orphaned visitors.");
        }

        $this->info('Analytics cleanup complete.');
        return 0;
    }
}
