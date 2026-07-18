<?php

namespace Modules\CRM\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Agent;
use App\Models\JobTitle;
use App\Models\Rank;
use App\Models\User;

class AgentController extends Controller
{
    protected $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function index()
    {
        $agents = Agent::list();

        return view('crm::agents.index', [
            'agents' => $agents
        ]);
    }

    public function create()
    {
        $users = User::orderBy('name', 'asc')->get();
        $jobTitles = JobTitle::whereNull('deleted_at')->get();
        $ranks = Rank::whereNull('deleted_at')->get();

        return view('crm::agents.create', [
            'users' => $users,
            'jobTitles' => $jobTitles,
            'ranks' => $ranks
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'full_name_en' => 'required|string|max:255',
            'full_name_ar' => 'required|string|max:255',
            'job_title_id' => 'required|exists:job_titles,id',
            'rank_id' => 'required|exists:ranks,id',
            'status' => 'required|in:Active,Not Active',
        ]);

        Agent::create($data);

        return redirect()->route('crm-agents.index')->with('success', 'Agent created successfully!');
    }

    public function show($id)
    {
        $agent = Agent::findWithRelations($id);

        if (!$agent) {
            return redirect()->route('crm-agents.index')->with('error', 'Agent not found!');
        }

        return view('crm::agents.show', [
            'agent' => $agent
        ]);
    }

    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        $users = User::orderBy('name', 'asc')->get();
        $jobTitles = JobTitle::whereNull('deleted_at')->get();
        $ranks = Rank::whereNull('deleted_at')->get();

        return view('crm::agents.edit', [
            'agent' => $agent,
            'users' => $users,
            'jobTitles' => $jobTitles,
            'ranks' => $ranks
        ]);
    }

    public function update(Request $request, $id)
    {
        $agent = Agent::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'full_name_en' => 'required|string|max:255',
            'full_name_ar' => 'required|string|max:255',
            'job_title_id' => 'required|exists:job_titles,id',
            'rank_id' => 'required|exists:ranks,id',
            'status' => 'required|in:Active,Not Active',
        ]);

        $agent->update($data);

        return redirect()->route('crm-agents.index')->with('success', 'Agent updated successfully!');
    }

    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);

        // Clear references before soft delete: agents is MyISAM (no FK), so
        // stale assignments would otherwise remain and display incorrectly.
        User::where('assigned_agent_id', $id)->update(['assigned_agent_id' => null]);
        DB::table('favourites')->where('sales_agent_id', $id)->update(['sales_agent_id' => null]);

        $agent->delete();

        return redirect()->route('crm-agents.index')->with('success', 'Agent deleted successfully!');
    }

    public function trashed()
    {
        $agents = Agent::trashed();

        return view('crm::agents.trashed', [
            'agents' => $agents
        ]);
    }

    public function restore($id)
    {
        $agent = Agent::withTrashed()->findOrFail($id);
        $agent->restore();

        return redirect()->route('crm-agents.trashed')->with('success', 'Agent restored successfully!');
    }
}
