<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use App\Models\Project;
use App\Models\Offer;
use App\Models\InteriorDesignGallery;
use App\Models\Agent;
use App\Models\FavouriteComment;
use App\Models\FavouriteEmailLog;
use App\Mail\FavouritesDirectMail;
use App\Mail\FavouritesNotificationMail;
use App\Exports\FavouritesReportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

class FavouritesController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('favourites')
            ->leftJoin('agents', 'favourites.sales_agent_id', '=', 'agents.id')
            ->select(
                'favourites.session_id',
                DB::raw('COUNT(*) as items_count'),
                DB::raw('MAX(favourites.name) as name'),
                DB::raw('MAX(favourites.email) as email'),
                DB::raw('MAX(favourites.mobile) as mobile'),
                DB::raw('MIN(favourites.expires_at) as expires_at'),
                DB::raw('MAX(favourites.is_permanent) as is_permanent'),
                DB::raw('MIN(favourites.created_at) as created_at'),
                DB::raw('MAX(favourites.created_at) as last_added_at'),
                DB::raw("GROUP_CONCAT(DISTINCT favourites.item_type SEPARATOR ',') as item_types"),
                DB::raw('MAX(favourites.sales_agent_id) as sales_agent_id'),
                DB::raw('MAX(agents.full_name_en) as agent_name')
            )
            ->groupBy('favourites.session_id');

        if ($request->filled('ref_id')) {
            $query->where('favourites.session_id', 'like', strtolower($request->ref_id) . '%');
        }

        if ($request->filled('name')) {
            $query->having('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->having('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('mobile')) {
            $query->having('mobile', 'like', '%' . $request->mobile . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->having(DB::raw('MAX(favourites.is_permanent)'), '=', 0)
                      ->having('expires_at', '>', now());
            } elseif ($request->status === 'expired') {
                $query->having(DB::raw('MAX(favourites.is_permanent)'), '=', 0)
                      ->having('expires_at', '<=', now());
            } elseif ($request->status === 'permanent') {
                $query->having(DB::raw('MAX(favourites.is_permanent)'), '=', 1);
            }
        }

        if ($request->filled('type')) {
            $query->having(DB::raw("GROUP_CONCAT(DISTINCT favourites.item_type SEPARATOR ',')"), 'like', '%' . $request->type . '%');
        }

        if ($request->filled('has_email')) {
            if ($request->has_email === 'yes') {
                $query->having('email', '!=', null)->having('email', '!=', '');
            } else {
                $query->havingRaw("(MAX(favourites.email) IS NULL OR MAX(favourites.email) = '')");
            }
        }

        if ($request->filled('date_from')) {
            $query->having('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->filled('date_to')) {
            $query->having(DB::raw('MAX(favourites.created_at)'), '<=', $request->date_to . ' 23:59:59');
        }

        if ($request->filled('agent')) {
            if ($request->agent === 'unassigned') {
                $query->havingRaw('MAX(favourites.sales_agent_id) IS NULL');
            } else {
                $query->having(DB::raw('MAX(favourites.sales_agent_id)'), '=', $request->agent);
            }
        }

        $totalCount = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query)
            ->count();

        $sessions = $query->orderByDesc('last_added_at')
            ->paginate(25)
            ->appends($request->query());

        $sessions->getCollection()->transform(function ($row) {
            $row->ref_id = strtoupper(substr($row->session_id, 0, 8));
            $row->is_expired = !$row->is_permanent && $row->expires_at && now()->greaterThan($row->expires_at);
            $row->share_url = url(app()->getLocale() . '/favourites/shared/' . $row->session_id);
            $row->types_array = array_filter(explode(',', $row->item_types ?? ''));
            return $row;
        });

        $agentsList = Agent::whereNull('deleted_at')->where('status', 'Active')->get();

        return view('crm::favourites.index', compact('sessions', 'totalCount', 'agentsList'));
    }

    public function liveSearch(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $results = DB::table('favourites')
            ->select(
                'session_id',
                DB::raw('COUNT(*) as items_count'),
                DB::raw('MAX(name) as name'),
                DB::raw('MAX(email) as email'),
                DB::raw('MAX(mobile) as mobile'),
                DB::raw('MIN(expires_at) as expires_at'),
                DB::raw('MAX(is_permanent) as is_permanent'),
                DB::raw("GROUP_CONCAT(DISTINCT item_type SEPARATOR ',') as item_types")
            )
            ->groupBy('session_id')
            ->having('session_id', 'like', strtolower($query) . '%')
            ->orHaving(DB::raw('MAX(name)'), 'like', '%' . $query . '%')
            ->orHaving(DB::raw('MAX(email)'), 'like', '%' . $query . '%')
            ->orHaving(DB::raw('MAX(mobile)'), 'like', '%' . $query . '%')
            ->orderByDesc(DB::raw('MAX(created_at)'))
            ->limit(10)
            ->get()
            ->map(function ($row) {
                $row->ref_id = strtoupper(substr($row->session_id, 0, 8));
                $row->is_expired = !$row->is_permanent && $row->expires_at && now()->greaterThan($row->expires_at);
                $row->status_label = $row->is_permanent ? 'Permanent' : ($row->is_expired ? 'Expired' : 'Active');
                $row->status_class = $row->is_permanent ? 'primary' : ($row->is_expired ? 'danger' : 'success');
                return $row;
            });

        return response()->json($results);
    }

    public function show($sessionId)
    {
        $favourites = Favourite::forSession($sessionId)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($favourites->isEmpty()) {
            abort(404);
        }

        $grouped = $this->groupFavourites($favourites);
        $totalCount = $grouped['projects']->count() + $grouped['offers']->count() + $grouped['interiors']->count();

        $userInfo = (object) [
            'name' => $favourites->whereNotNull('name')->first()->name ?? null,
            'email' => $favourites->whereNotNull('email')->first()->email ?? null,
            'mobile' => $favourites->whereNotNull('mobile')->first()->mobile ?? null,
        ];

        $first = $favourites->first();
        $meta = (object) [
            'ref_id' => strtoupper(substr($sessionId, 0, 8)),
            'session_id' => $sessionId,
            'share_url' => url(app()->getLocale() . '/favourites/shared/' . $sessionId),
            'expires_at' => $first->expires_at,
            'is_permanent' => $first->is_permanent,
            'is_expired' => $first->isExpired(),
            'created_at' => $favourites->min('created_at'),
            'last_added_at' => $favourites->max('created_at'),
            'sales_agent_id' => $first->sales_agent_id,
        ];

        $agents = Agent::whereNull('deleted_at')->where('status', 'Active')->get();

        $assignedAgent = null;
        if ($meta->sales_agent_id) {
            $assignedAgent = Agent::findWithRelations($meta->sales_agent_id);
        }

        $comments = FavouriteComment::where('session_id', $sessionId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $emailLogs = FavouriteEmailLog::where('session_id', $sessionId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('crm::favourites.show', compact('grouped', 'totalCount', 'userInfo', 'meta', 'agents', 'assignedAgent', 'comments', 'emailLogs'));
    }

    public function assignAgent(Request $request, $sessionId)
    {
        $request->validate([
            'sales_agent_id' => 'required|exists:agents,id',
        ]);

        DB::table('favourites')
            ->where('session_id', $sessionId)
            ->update(['sales_agent_id' => $request->sales_agent_id]);

        return redirect()->route('crm-favourites.show', ['sessionId' => $sessionId])
            ->with('success', 'Agent assigned successfully!');
    }

    public function unassignAgent($sessionId)
    {
        DB::table('favourites')
            ->where('session_id', $sessionId)
            ->update(['sales_agent_id' => null]);

        return redirect()->route('crm-favourites.show', ['sessionId' => $sessionId])
            ->with('success', 'Agent unassigned successfully!');
    }

    public function updateUserInfo(Request $request, $sessionId)
    {
        $request->validate([
            'name'   => 'nullable|string|max:255',
            'email'  => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:50',
        ]);

        DB::table('favourites')
            ->where('session_id', $sessionId)
            ->update([
                'name'   => $request->name,
                'email'  => $request->email,
                'mobile' => $request->mobile,
            ]);

        return redirect()->route('crm-favourites.show', ['sessionId' => $sessionId])
            ->with('success', 'User information updated successfully!');
    }

    public function deleteItem($id)
    {
        $favourite = Favourite::findOrFail($id);
        $sessionId = $favourite->session_id;
        $favourite->delete();

        $remaining = Favourite::where('session_id', $sessionId)->count();
        if ($remaining === 0) {
            return redirect()->route('crm-favourites.index')
                ->with('success', 'Item deleted. Session has no more items and was removed.');
        }

        return redirect()->route('crm-favourites.show', ['sessionId' => $sessionId])
            ->with('success', 'Item removed from favourites successfully!');
    }

    public function storeComment(Request $request, $sessionId)
    {
        $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        FavouriteComment::create([
            'session_id' => $sessionId,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->route('crm-favourites.show', ['sessionId' => $sessionId])
            ->with('success', 'Comment added successfully!');
    }

    public function deleteComment($id)
    {
        $comment = FavouriteComment::findOrFail($id);
        $sessionId = $comment->session_id;
        $comment->delete();

        return redirect()->route('crm-favourites.show', ['sessionId' => $sessionId])
            ->with('success', 'Comment deleted successfully!');
    }

    public function sendEmail(Request $request, $sessionId)
    {
        $request->validate([
            'subject'       => 'required|string|max:255',
            'body'          => 'required|string|max:5000',
            'attachments'   => 'nullable|array|max:5',
            'attachments.*' => 'file|max:10240',
        ]);

        $favourites = Favourite::forSession($sessionId)->get();
        if ($favourites->isEmpty()) {
            abort(404);
        }

        $userInfo = (object) [
            'email' => $favourites->whereNotNull('email')->first()->email ?? null,
        ];

        if (!$userInfo->email) {
            return redirect()->route('crm-favourites.show', ['sessionId' => $sessionId])
                ->with('error', 'Cannot send email — no email address found for this session.');
        }

        $storedPaths = [];
        $attachmentNames = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('temp_email_attachments', time() . '_' . $originalName, 'local');
                $storedPaths[] = storage_path('app/' . $path);
                $attachmentNames[] = $originalName;
            }
        }

        $ccEmail = null;
        $first = $favourites->first();
        if ($first->sales_agent_id) {
            $agent = Agent::findWithRelations($first->sales_agent_id);
            if ($agent && $agent->user_email) {
                $ccEmail = $agent->user_email;
            }
        }

        $mail = Mail::to($userInfo->email);
        if ($ccEmail) {
            $mail->cc($ccEmail);
        }
        $mail->send(new FavouritesDirectMail($request->subject, $request->body, $storedPaths, $attachmentNames));

        foreach ($storedPaths as $path) {
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        FavouriteEmailLog::create([
            'session_id'  => $sessionId,
            'user_id'     => Auth::id(),
            'to_email'    => $userInfo->email,
            'cc_email'    => $ccEmail,
            'subject'     => $request->subject,
            'body'        => $request->body,
            'attachments' => $attachmentNames ?: null,
            'type'        => 'direct',
        ]);

        return redirect()->route('crm-favourites.show', ['sessionId' => $sessionId])
            ->with('success', 'Email sent successfully to ' . $userInfo->email . '!');
    }

    public function sendNotification(Request $request, $sessionId)
    {
        $request->validate([
            'update_note' => 'nullable|string|max:1000',
        ]);

        $favourites = Favourite::forSession($sessionId)->orderBy('created_at', 'desc')->get();
        if ($favourites->isEmpty()) {
            abort(404);
        }

        $userInfo = (object) [
            'name'  => $favourites->whereNotNull('name')->first()->name ?? null,
            'email' => $favourites->whereNotNull('email')->first()->email ?? null,
        ];

        if (!$userInfo->email) {
            return redirect()->route('crm-favourites.show', ['sessionId' => $sessionId])
                ->with('error', 'Cannot send notification — no email address found for this session.');
        }

        $grouped = $this->groupFavourites($favourites);
        $refId = strtoupper(substr($sessionId, 0, 8));
        $shareUrl = url(app()->getLocale() . '/favourites/shared/' . $sessionId);

        $ccEmail = null;
        $first = $favourites->first();
        if ($first->sales_agent_id) {
            $agent = Agent::findWithRelations($first->sales_agent_id);
            if ($agent && $agent->user_email) {
                $ccEmail = $agent->user_email;
            }
        }

        $mail = Mail::to($userInfo->email);
        if ($ccEmail) {
            $mail->cc($ccEmail);
        }
        $mail->send(new FavouritesNotificationMail(
            $grouped,
            $shareUrl,
            $userInfo->name,
            $refId,
            $request->update_note
        ));

        FavouriteEmailLog::create([
            'session_id'  => $sessionId,
            'user_id'     => Auth::id(),
            'to_email'    => $userInfo->email,
            'cc_email'    => $ccEmail,
            'subject'     => 'Favourites Update - Smart Vision Engineering Consultant',
            'body'        => $request->update_note,
            'attachments' => null,
            'type'        => 'notification',
        ]);

        return redirect()->route('crm-favourites.show', ['sessionId' => $sessionId])
            ->with('success', 'Notification email with favourites list sent to ' . $userInfo->email . '!');
    }

    private function buildFilteredSessionsQuery(Request $request)
    {
        $query = DB::table('favourites')
            ->leftJoin('agents', 'favourites.sales_agent_id', '=', 'agents.id')
            ->select(
                'favourites.session_id',
                DB::raw('COUNT(*) as items_count'),
                DB::raw('MAX(favourites.name) as name'),
                DB::raw('MAX(favourites.email) as email'),
                DB::raw('MAX(favourites.mobile) as mobile'),
                DB::raw('MIN(favourites.expires_at) as expires_at'),
                DB::raw('MAX(favourites.is_permanent) as is_permanent'),
                DB::raw('MIN(favourites.created_at) as created_at'),
                DB::raw('MAX(favourites.created_at) as last_added_at'),
                DB::raw("GROUP_CONCAT(DISTINCT favourites.item_type SEPARATOR ',') as item_types"),
                DB::raw('MAX(favourites.sales_agent_id) as sales_agent_id'),
                DB::raw('MAX(agents.full_name_en) as agent_name')
            )
            ->groupBy('favourites.session_id');

        if ($request->filled('ref_id')) {
            $query->where('favourites.session_id', 'like', strtolower($request->ref_id) . '%');
        }
        if ($request->filled('name')) {
            $query->having('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->having('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('mobile')) {
            $query->having('mobile', 'like', '%' . $request->mobile . '%');
        }
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->having(DB::raw('MAX(favourites.is_permanent)'), '=', 0)
                      ->having('expires_at', '>', now());
            } elseif ($request->status === 'expired') {
                $query->having(DB::raw('MAX(favourites.is_permanent)'), '=', 0)
                      ->having('expires_at', '<=', now());
            } elseif ($request->status === 'permanent') {
                $query->having(DB::raw('MAX(favourites.is_permanent)'), '=', 1);
            }
        }
        if ($request->filled('type')) {
            $query->having(DB::raw("GROUP_CONCAT(DISTINCT favourites.item_type SEPARATOR ',')"), 'like', '%' . $request->type . '%');
        }
        if ($request->filled('has_email')) {
            if ($request->has_email === 'yes') {
                $query->having('email', '!=', null)->having('email', '!=', '');
            } else {
                $query->havingRaw("(MAX(favourites.email) IS NULL OR MAX(favourites.email) = '')");
            }
        }
        if ($request->filled('date_from')) {
            $query->having('created_at', '>=', $request->date_from . ' 00:00:00');
        }
        if ($request->filled('date_to')) {
            $query->having(DB::raw('MAX(favourites.created_at)'), '<=', $request->date_to . ' 23:59:59');
        }
        if ($request->filled('agent')) {
            if ($request->agent === 'unassigned') {
                $query->havingRaw('MAX(favourites.sales_agent_id) IS NULL');
            } else {
                $query->having(DB::raw('MAX(favourites.sales_agent_id)'), '=', $request->agent);
            }
        }

        return $query;
    }

    private function buildReportRows($sessions)
    {
        $allSessionIds = collect($sessions)->pluck('session_id')->toArray();

        $allFavourites = DB::table('favourites')
            ->whereIn('session_id', $allSessionIds)
            ->select('session_id', 'item_type', 'item_id')
            ->get();

        $projectIds = $allFavourites->where('item_type', 'project')->pluck('item_id')->unique()->toArray();
        $offerIds = $allFavourites->where('item_type', 'offer')->pluck('item_id')->unique()->toArray();

        $projectCodes = [];
        if (!empty($projectIds)) {
            $projectCodes = DB::table('projects')
                ->whereIn('id', $projectIds)
                ->pluck('project_code', 'id')
                ->toArray();
        }

        $offerCodes = [];
        if (!empty($offerIds)) {
            $offerCodes = DB::table('offers')
                ->whereIn('id', $offerIds)
                ->pluck('offer_code', 'id')
                ->toArray();
        }

        $grouped = $allFavourites->groupBy('session_id');

        $rows = [];
        foreach ($sessions as $session) {
            $sessionFavs = $grouped->get($session->session_id, collect());

            $sessionProjectIds = $sessionFavs->where('item_type', 'project')->pluck('item_id')->unique();
            $sessionOfferIds = $sessionFavs->where('item_type', 'offer')->pluck('item_id')->unique();
            $sessionInteriorIds = $sessionFavs->where('item_type', 'interior')->pluck('item_id')->unique();

            $pCodes = $sessionProjectIds->map(fn($id) => $projectCodes[$id] ?? 'P-' . $id)->filter()->implode(', ');
            $oCodes = $sessionOfferIds->map(fn($id) => $offerCodes[$id] ?? 'O-' . $id)->filter()->implode(', ');
            $iIds = $sessionInteriorIds->implode(', ');

            $types = collect(array_filter(explode(',', $session->item_types ?? '')))
                ->map(fn($t) => ucfirst(trim($t)))
                ->implode(', ');

            $rows[] = [
                'ref_id' => strtoupper(substr($session->session_id, 0, 8)),
                'name' => $session->name ?: '',
                'email' => $session->email ?: '',
                'mobile' => $session->mobile ?: '',
                'types' => $types,
                'project_codes' => $pCodes,
                'offer_codes' => $oCodes,
                'interior_ids' => $iIds,
                'agent' => $session->agent_name ?: '',
            ];
        }

        return $rows;
    }

    private function getActiveFilters(Request $request)
    {
        $filters = [];
        if ($request->filled('ref_id')) $filters[] = 'Ref ID: ' . $request->ref_id;
        if ($request->filled('name')) $filters[] = 'Name: ' . $request->name;
        if ($request->filled('email')) $filters[] = 'Email: ' . $request->email;
        if ($request->filled('mobile')) $filters[] = 'Mobile: ' . $request->mobile;
        if ($request->filled('status')) $filters[] = 'Status: ' . ucfirst($request->status);
        if ($request->filled('type')) $filters[] = 'Type: ' . ucfirst($request->type);
        if ($request->filled('has_email')) $filters[] = 'Has Email: ' . ($request->has_email === 'yes' ? 'Yes' : 'No');
        if ($request->filled('agent')) {
            if ($request->agent === 'unassigned') {
                $filters[] = 'Agent: Unassigned';
            } else {
                $agent = Agent::find($request->agent);
                $filters[] = 'Agent: ' . ($agent ? $agent->full_name_en : $request->agent);
            }
        }
        if ($request->filled('date_from')) $filters[] = 'From: ' . $request->date_from;
        if ($request->filled('date_to')) $filters[] = 'To: ' . $request->date_to;
        return $filters;
    }

    public function exportReport(Request $request)
    {
        $format = $request->get('format', 'excel');

        $sessions = $this->buildFilteredSessionsQuery($request)
            ->orderByDesc('last_added_at')
            ->get();

        $rows = $this->buildReportRows($sessions);
        $activeFilters = $this->getActiveFilters($request);

        if ($format === 'pdf') {
            $pdf = LaravelMpdf::loadView('exports.favourites-report-pdf', [
                'rows' => $rows,
                'activeFilters' => $activeFilters,
            ], [], [
                'format' => 'A4-L',
                'orientation' => 'L',
                'default_font' => 'XB Riyaz',
                'autoLangToFont' => true,
                'autoScriptToLang' => true,
            ]);

            return $pdf->download('favourites-report-' . now()->format('Y-m-d') . '.pdf');
        }

        $collection = collect($rows);
        return Excel::download(
            new FavouritesReportExport($collection),
            'favourites-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    private function groupFavourites($favourites): array
    {
        $projectIds = $favourites->where('item_type', 'project')->pluck('item_id');
        $offerIds = $favourites->where('item_type', 'offer')->pluck('item_id');
        $interiorIds = $favourites->where('item_type', 'interior')->pluck('item_id');

        $projects = Project::whereIn('id', $projectIds)
            ->with(['category', 'subcategory', 'emirate', 'specifications'])
            ->get()->keyBy('id');

        $offers = Offer::whereIn('id', $offerIds)
            ->with(['category', 'subcategory', 'prices.emirate', 'currency', 'specifications'])
            ->get()->keyBy('id');

        $interiors = InteriorDesignGallery::whereIn('id', $interiorIds)
            ->with(['category', 'projectStyle'])
            ->get()->keyBy('id');

        return [
            'projects' => $favourites->where('item_type', 'project')->map(function ($fav) use ($projects) {
                $fav->itemData = $projects->get($fav->item_id);
                return $fav;
            })->filter(fn($fav) => $fav->itemData !== null),

            'offers' => $favourites->where('item_type', 'offer')->map(function ($fav) use ($offers) {
                $fav->itemData = $offers->get($fav->item_id);
                if ($fav->itemData && $fav->emirate_id) {
                    $fav->selectedPrice = $fav->itemData->prices->firstWhere('emirate_id', $fav->emirate_id);
                }
                return $fav;
            })->filter(fn($fav) => $fav->itemData !== null),

            'interiors' => $favourites->where('item_type', 'interior')->map(function ($fav) use ($interiors) {
                $fav->itemData = $interiors->get($fav->item_id);
                return $fav;
            })->filter(fn($fav) => $fav->itemData !== null),
        ];
    }
}
