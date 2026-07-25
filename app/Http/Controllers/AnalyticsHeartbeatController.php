<?php

namespace App\Http\Controllers;

use App\Models\Analytics\AnalyticsPageView;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Records time-on-page for the current visitor.
 *
 * Extracted from a closure in routes/web.php so it can be tested and so the input can be
 * bounded. CSRF-exempt (see VerifyCsrfToken) and unauthenticated, so everything it writes
 * is treated as untrusted.
 */
class AnalyticsHeartbeatController extends Controller
{
    /** Nobody is on one page for longer than this; anything above is noise or abuse. */
    private const MAX_TIME_ON_PAGE = 3600;

    public function __invoke(Request $request): JsonResponse
    {
        $visitorId = $request->cookie('svec_vid');

        if (!$visitorId) {
            return response()->json(['ok' => false], 200);
        }

        $pageView = AnalyticsPageView::where('visitor_id', $visitorId)
            ->orderBy('viewed_at', 'desc')
            ->first();

        if (!$pageView) {
            return response()->json(['ok' => false], 200);
        }

        $updates = [];

        if ($request->filled('time_on_page')) {
            // Was cast straight from request input with no ceiling, so a single crafted
            // request could skew every average-session-duration figure on the dashboard.
            $updates['time_on_page'] = min(
                max((int) $request->input('time_on_page'), 0),
                self::MAX_TIME_ON_PAGE
            );
        }

        // Title is written once and never overwritten, so a later request cannot rewrite
        // the recorded title of a page someone already visited.
        if ($request->filled('title') && !$pageView->page_title) {
            $updates['page_title'] = Str::limit((string) $request->input('title'), 500, '');
        }

        if ($updates) {
            $pageView->update($updates);
        }

        return response()->json(['ok' => true], 200);
    }
}
