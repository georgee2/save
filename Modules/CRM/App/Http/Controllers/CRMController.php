<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CRMController extends Controller
{
    public function index()
    {
        $contactStats = DB::table('contact_us')
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'InProgress' THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN status = 'Done' THEN 1 ELSE 0 END) as done,
                SUM(CASE WHEN agent_id IS NOT NULL THEN 1 ELSE 0 END) as assigned,
                SUM(CASE WHEN agent_id IS NULL THEN 1 ELSE 0 END) as unassigned,
                SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as this_week,
                SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as today
            ", [Carbon::now()->startOfWeek(), Carbon::today()])
            ->first();

        $favStats = DB::table('favourites')
            ->selectRaw("
                COUNT(DISTINCT session_id) as total_sessions,
                COUNT(*) as total_items,
                SUM(CASE WHEN item_type = 'project' THEN 1 ELSE 0 END) as projects,
                SUM(CASE WHEN item_type = 'offer' THEN 1 ELSE 0 END) as offers,
                SUM(CASE WHEN item_type = 'interior' THEN 1 ELSE 0 END) as interiors
            ")
            ->first();

        $favAssigned = DB::table('favourites')
            ->select('session_id')
            ->distinct()
            ->whereNotNull('sales_agent_id')
            ->count('session_id');

        $emailsSent = DB::table('contact_us_email_logs')->count();
        $commentsMade = DB::table('contact_us_comments')->count();
        $agentsCount = DB::table('agents')->whereNull('deleted_at')->where('status', 'Active')->count();

        $topProjects = DB::table('favourites')
            ->leftJoin('projects', 'favourites.item_id', '=', 'projects.id')
            ->where('favourites.item_type', 'project')
            ->select('favourites.item_id', 'projects.project_code as code', 'projects.title_english as title', DB::raw('COUNT(*) as fav_count'))
            ->groupBy('favourites.item_id', 'projects.project_code', 'projects.title_english')
            ->orderByDesc('fav_count')
            ->limit(10)
            ->get();

        $topOffers = DB::table('favourites')
            ->leftJoin('offers', 'favourites.item_id', '=', 'offers.id')
            ->where('favourites.item_type', 'offer')
            ->select('favourites.item_id', 'offers.offer_code as code', 'offers.title_english as title', DB::raw('COUNT(*) as fav_count'))
            ->groupBy('favourites.item_id', 'offers.offer_code', 'offers.title_english')
            ->orderByDesc('fav_count')
            ->limit(10)
            ->get();

        $topInteriors = DB::table('favourites')
            ->leftJoin('interior_design_galleries', 'favourites.item_id', '=', 'interior_design_galleries.id')
            ->where('favourites.item_type', 'interior')
            ->select('favourites.item_id', 'interior_design_galleries.title_english as title', DB::raw('COUNT(*) as fav_count'))
            ->groupBy('favourites.item_id', 'interior_design_galleries.title_english')
            ->orderByDesc('fav_count')
            ->limit(10)
            ->get();

        $contactByMonth = DB::table('contact_us')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $favByMonth = DB::table('favourites')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(DISTINCT session_id) as count")
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = Carbon::now()->subMonths($i)->format('Y-m');
        }

        $contactTrend = [];
        $favTrend = [];
        $monthLabels = [];
        foreach ($months as $m) {
            $contactTrend[] = $contactByMonth[$m] ?? 0;
            $favTrend[] = $favByMonth[$m] ?? 0;
            $monthLabels[] = Carbon::createFromFormat('Y-m', $m)->format('M Y');
        }

        $contactByService = DB::table('contact_us')
            ->leftJoin('services', 'contact_us.service_id', '=', 'services.id')
            ->whereNotNull('contact_us.service_id')
            ->select('services.title_english as service', DB::raw('COUNT(*) as count'))
            ->groupBy('services.title_english')
            ->orderByDesc('count')
            ->limit(8)
            ->get();

        $recentContacts = DB::table('contact_us')
            ->leftJoin('agents', 'contact_us.agent_id', '=', 'agents.id')
            ->select('contact_us.id', 'contact_us.name', 'contact_us.email', 'contact_us.subject', 'contact_us.status', 'contact_us.created_at', 'agents.full_name_en as agent_name')
            ->orderByDesc('contact_us.created_at')
            ->limit(5)
            ->get();

        $agentPerformance = DB::table('agents')
            ->leftJoin(DB::raw('(SELECT agent_id, COUNT(*) as contact_count FROM contact_us WHERE agent_id IS NOT NULL GROUP BY agent_id) as cc'), 'agents.id', '=', 'cc.agent_id')
            ->leftJoin(DB::raw('(SELECT sales_agent_id, COUNT(DISTINCT session_id) as fav_count FROM favourites WHERE sales_agent_id IS NOT NULL GROUP BY sales_agent_id) as fc'), 'agents.id', '=', 'fc.sales_agent_id')
            ->whereNull('agents.deleted_at')
            ->where('agents.status', 'Active')
            ->select('agents.id', 'agents.full_name_en', DB::raw('COALESCE(cc.contact_count, 0) as contacts_assigned'), DB::raw('COALESCE(fc.fav_count, 0) as favs_assigned'))
            ->orderByDesc(DB::raw('COALESCE(cc.contact_count, 0) + COALESCE(fc.fav_count, 0)'))
            ->get();

        return view('crm::index', compact(
            'contactStats', 'favStats', 'favAssigned', 'emailsSent', 'commentsMade', 'agentsCount',
            'topProjects', 'topOffers', 'topInteriors',
            'contactTrend', 'favTrend', 'monthLabels',
            'contactByService', 'recentContacts', 'agentPerformance'
        ));
    }
}
