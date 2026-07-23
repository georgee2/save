<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use App\Models\CustomerComment;
use App\Models\CustomerEmailLog;
use App\Models\Favourite;
use App\Mail\CustomerDirectMail;
use App\Exports\CustomersReportExport;
use App\Support\GroupsFavourites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

class CustomersController extends Controller
{
    use GroupsFavourites;

    public function index(Request $request)
    {
        $query = $this->buildFilteredQuery($request);

        $totalCount = (clone $query)->count('users.id');

        $customers = $query->orderByDesc('users.created_at')
            ->paginate(25)
            ->appends($request->query());

        $agentsList = Agent::whereNull('deleted_at')->where('status', 'Active')->get();

        return view('crm::customers.index', compact('customers', 'totalCount', 'agentsList'));
    }

    public function liveSearch(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 1) {
            return response()->json([]);
        }

        $results = DB::table('users')
            ->where('users.account_type', 'customer')
            ->whereNull('users.deleted_at')
            ->where(function ($sub) use ($q) {
                $sub->where('users.name', 'like', '%' . $q . '%')
                    ->orWhere('users.email', 'like', '%' . $q . '%')
                    ->orWhere('users.phone', 'like', '%' . $q . '%');
            })
            ->select('users.id', 'users.name', 'users.email', 'users.phone', 'users.password_set_at')
            ->orderByDesc('users.created_at')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                $activated = !is_null($row->password_set_at);
                $row->status_label = $activated ? 'Activated' : 'Pending';
                $row->status_class = $activated ? 'success' : 'warning';
                return $row;
            });

        return response()->json($results);
    }

    public function show($id)
    {
        $customer = User::customers()->whereNull('deleted_at')->findOrFail($id);

        $agents = Agent::whereNull('deleted_at')->where('status', 'Active')->get();

        $assignedAgent = null;
        if ($customer->assigned_agent_id) {
            $assignedAgent = Agent::findWithRelations($customer->assigned_agent_id);
        }

        $comments = CustomerComment::where('customer_id', $id)
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'comments_page');

        $emailLogs = CustomerEmailLog::where('customer_id', $id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'emails_page');

        // Placeholder until the ERP/projects sub-plan lands.
        $projectCount = 0;

        // The customer's account-linked favourites (guest lists merged on login).
        $favourites = Favourite::forUser($id)->active()->orderBy('created_at', 'desc')->get();
        $favGrouped = $this->groupFavourites($favourites);
        $favTotal = $favGrouped['projects']->count() + $favGrouped['offers']->count() + $favGrouped['interiors']->count();
        $favToken = $customer->favourites_token;

        return view('crm::customers.show', compact('customer', 'agents', 'assignedAgent', 'comments', 'emailLogs', 'projectCount', 'favGrouped', 'favTotal', 'favToken'));
    }

    public function assignAgent(Request $request, $id)
    {
        $request->validate([
            'assigned_agent_id' => 'required|exists:agents,id',
        ]);

        $customer = User::customers()->whereNull('deleted_at')->findOrFail($id);
        $customer->update(['assigned_agent_id' => $request->assigned_agent_id]);

        return redirect()->route('crm-customers.show', ['id' => $id])
            ->with('success', 'Agent assigned successfully!');
    }

    public function unassignAgent($id)
    {
        $customer = User::customers()->whereNull('deleted_at')->findOrFail($id);
        $customer->update(['assigned_agent_id' => null]);

        return redirect()->route('crm-customers.show', ['id' => $id])
            ->with('success', 'Agent unassigned successfully!');
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        $customer = User::customers()->whereNull('deleted_at')->findOrFail($id);

        CustomerComment::create([
            'customer_id' => $customer->id,
            'author_id'   => Auth::id(),
            'comment'     => $request->comment,
        ]);

        return redirect()->route('crm-customers.show', ['id' => $id])
            ->with('success', 'Comment added successfully!');
    }

    public function deleteComment($id)
    {
        $comment = CustomerComment::findOrFail($id);
        $customerId = $comment->customer_id;
        $comment->delete();

        return redirect()->route('crm-customers.show', ['id' => $customerId])
            ->with('success', 'Comment deleted successfully!');
    }

    public function sendEmail(Request $request, $id)
    {
        $request->validate([
            'subject'       => 'required|string|max:255',
            'body'          => 'required|string|max:5000',
            'attachments'   => 'nullable|array|max:5',
            'attachments.*' => 'file|max:10240',
        ]);

        $customer = User::customers()->whereNull('deleted_at')->findOrFail($id);

        if (!$customer->email) {
            return redirect()->route('crm-customers.show', ['id' => $id])
                ->with('error', 'Cannot send email — this customer has no email address.');
        }

        if (!$customer->acceptsDirectEmail()) {
            return redirect()->route('crm-customers.show', ['id' => $id])
                ->with('error', 'Cannot send email — this customer has not consented to or has opted out of email updates.');
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
        if ($customer->assigned_agent_id) {
            $agent = Agent::findWithRelations($customer->assigned_agent_id);
            if ($agent && $agent->user_email) {
                $ccEmail = $agent->user_email;
            }
        }

        $toEmail = $customer->email;
        $subject = $request->subject;
        $body = $request->body;

        // Log first as "queued", then reconcile the real outcome after the send.
        $log = CustomerEmailLog::create([
            'customer_id' => $customer->id,
            'sent_by'     => Auth::id(),
            'to_email'    => $toEmail,
            'cc_email'    => $ccEmail,
            'subject'     => $subject,
            'body'        => $body,
            'attachments' => $attachmentNames ?: null,
            'type'        => 'direct',
            'status'      => 'queued',
        ]);

        // Send asynchronously so the request is not blocked by remote SMTP.
        dispatch(function () use ($log, $toEmail, $ccEmail, $subject, $body, $storedPaths, $attachmentNames) {
            try {
                $mail = Mail::to($toEmail);
                if ($ccEmail) {
                    $mail->cc($ccEmail);
                }
                $mail->send(new CustomerDirectMail($subject, $body, $storedPaths, $attachmentNames));
                $log->updateQuietly(['status' => 'sent']);
            } catch (\Throwable $e) {
                $log->updateQuietly(['status' => 'failed']);
                Log::error('Customer direct email failed', ['log_id' => $log->id, 'error' => $e->getMessage()]);
            } finally {
                foreach ($storedPaths as $path) {
                    if (file_exists($path)) {
                        @unlink($path);
                    }
                }
            }
        })->afterResponse();

        return redirect()->route('crm-customers.show', ['id' => $id])
            ->with('success', 'Email is being sent to ' . $toEmail . '.');
    }

    public function exportReport(Request $request)
    {
        $format = $request->get('format', 'excel');

        $customers = $this->buildFilteredQuery($request)
            ->orderByDesc('users.created_at')
            ->get();

        $rows = $this->buildReportRows($customers);
        $activeFilters = $this->getActiveFilters($request);

        if ($format === 'pdf') {
            $pdf = LaravelMpdf::loadView('exports.customers-report-pdf', [
                'rows' => $rows,
                'activeFilters' => $activeFilters,
            ], [], [
                'format' => 'A4-L',
                'orientation' => 'L',
                'default_font' => 'XB Riyaz',
                'autoLangToFont' => true,
                'autoScriptToLang' => true,
            ]);

            return $pdf->download('customers-report-' . now()->format('Y-m-d') . '.pdf');
        }

        return Excel::download(
            new CustomersReportExport(collect($rows)),
            'customers-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    private function buildFilteredQuery(Request $request)
    {
        $query = DB::table('users')
            ->leftJoin('agents', function ($join) {
                $join->on('users.assigned_agent_id', '=', 'agents.id')
                     ->whereNull('agents.deleted_at');
            })
            ->where('users.account_type', 'customer')
            ->whereNull('users.deleted_at')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.phone',
                'users.created_at',
                'users.password_set_at',
                'users.email_verified_at',
                'users.erp_customer_id',
                'users.source',
                'users.synced_at',
                'users.assigned_agent_id',
                'agents.full_name_en as agent_name'
            );

        if ($request->filled('name')) {
            $query->where('users.name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('users.email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('phone')) {
            $query->where('users.phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->filled('status')) {
            if ($request->status === 'activated') {
                $query->whereNotNull('users.password_set_at');
            } elseif ($request->status === 'pending') {
                $query->whereNull('users.password_set_at');
            }
        }
        if ($request->filled('verified')) {
            if ($request->verified === 'yes') {
                $query->whereNotNull('users.email_verified_at');
            } elseif ($request->verified === 'no') {
                $query->whereNull('users.email_verified_at');
            }
        }
        if ($request->filled('erp_sync')) {
            if ($request->erp_sync === 'linked') {
                $query->whereNotNull('users.erp_customer_id');
            } elseif ($request->erp_sync === 'not_linked') {
                $query->whereNull('users.erp_customer_id');
            }
        }
        if ($request->filled('agent')) {
            if ($request->agent === 'unassigned') {
                $query->whereNull('users.assigned_agent_id');
            } else {
                $query->where('users.assigned_agent_id', $request->agent);
            }
        }
        if ($request->filled('date_from')) {
            $query->where('users.created_at', '>=', $request->date_from . ' 00:00:00');
        }
        if ($request->filled('date_to')) {
            $query->where('users.created_at', '<=', $request->date_to . ' 23:59:59');
        }

        return $query;
    }

    private function buildReportRows($customers): array
    {
        $rows = [];
        foreach ($customers as $customer) {
            $rows[] = [
                'name'     => $customer->name ?: '',
                'email'    => $customer->email ?: '',
                'phone'    => $customer->phone ?: '',
                'status'   => $customer->password_set_at ? 'Activated' : 'Pending',
                'verified' => $customer->email_verified_at ? 'Yes' : 'No',
                'agent'    => $customer->agent_name ?: '',
                'erp_id'   => $customer->erp_customer_id ?: '',
                'created'  => $customer->created_at ? \Carbon\Carbon::parse($customer->created_at)->format('Y-m-d') : '',
            ];
        }

        return $rows;
    }

    private function getActiveFilters(Request $request): array
    {
        $filters = [];
        if ($request->filled('name')) $filters[] = 'Name: ' . $request->name;
        if ($request->filled('email')) $filters[] = 'Email: ' . $request->email;
        if ($request->filled('phone')) $filters[] = 'Phone: ' . $request->phone;
        if ($request->filled('status')) $filters[] = 'Status: ' . ucfirst($request->status);
        if ($request->filled('verified')) $filters[] = 'Verified: ' . ($request->verified === 'yes' ? 'Yes' : 'No');
        if ($request->filled('erp_sync')) $filters[] = 'ERP: ' . ($request->erp_sync === 'linked' ? 'Linked' : 'Not linked');
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
}
