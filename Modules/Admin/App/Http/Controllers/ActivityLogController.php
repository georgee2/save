<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs with pagination and filters
     */
    public function index(Request $request)
    {
        $filters = [
            'user_id' => $request->get('user_id'),
            'action' => $request->get('action'),
            'model_name' => $request->get('model_name'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
            'search' => $request->get('search'),
        ];

        $logs = ActivityLog::getFiltered($filters, 20);
        
        // Get filter options
        $modelNames = ActivityLog::getDistinctModelNames();
        $actions = ActivityLog::getDistinctActions();
        $users = ActivityLog::getDistinctUsers();

        return view('admin::activity-logs.index', compact('logs', 'filters', 'modelNames', 'actions', 'users'));
    }

    /**
     * Show details of a specific log entry
     */
    public function show($id)
    {
        $log = ActivityLog::findOrFail($id);
        
        return view('admin::activity-logs.show', compact('log'));
    }

    /**
     * Clear old logs (optional - admin only)
     */
    public function clearOld(Request $request)
    {
        $days = $request->get('days', 90);
        
        $deleted = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();
        
        return redirect()->route('admin.activity-logs.index')
            ->with('success', "Deleted {$deleted} activity logs older than {$days} days.");
    }
}
