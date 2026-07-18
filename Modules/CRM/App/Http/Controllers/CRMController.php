<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CRMController extends Controller
{
    /**
     * Display the CRM dashboard with live KPIs.
     */
    public function index()
    {
        $customersBase = User::customers()->whereNull('deleted_at');

        $kpis = [
            'total_customers' => (clone $customersBase)->count(),
            'activated'       => (clone $customersBase)->whereNotNull('password_set_at')->count(),
            'pending'         => (clone $customersBase)->whereNull('password_set_at')->count(),
            'new_this_week'   => (clone $customersBase)->where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
            'new_this_month'  => (clone $customersBase)->where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'unassigned'      => (clone $customersBase)->whereNull('assigned_agent_id')->count(),
            'active_agents'   => Agent::whereNull('deleted_at')->where('status', 'Active')->count(),
            'favourites'      => Schema::hasTable('favourites')
                ? DB::table('favourites')->distinct('session_id')->count('session_id')
                : 0,
            'contacts'        => Schema::hasTable('contact_us')
                ? DB::table('contact_us')->count()
                : 0,
        ];

        // Registrations over the last 12 months.
        $months = [];
        $registrations = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->startOfMonth()->subMonths($i);
            $months[] = $month->format('M Y');
            $registrations[] = (clone $customersBase)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }
        $chart = ['months' => $months, 'registrations' => $registrations];

        $recentCustomers = User::customers()
            ->whereNull('users.deleted_at')
            ->with('assignedAgent')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        return view('crm::index', compact('kpis', 'chart', 'recentCustomers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crm::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('crm::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('crm::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
