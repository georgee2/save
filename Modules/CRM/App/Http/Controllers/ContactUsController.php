<?php

namespace Modules\CRM\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ContactUs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\ContactUsReplyMail;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('contact_us')
            ->leftJoin('services', 'contact_us.service_id', '=', 'services.id')
            ->leftJoin('agents', 'contact_us.agent_id', '=', 'agents.id')
            ->select(
                'contact_us.*',
                'services.title_english as service_name',
                'agents.full_name_en as agent_name'
            );

        if ($request->filled('name')) {
            $query->where('contact_us.name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('contact_us.email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('phone')) {
            $query->where('contact_us.phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('status')) {
            $query->where('contact_us.status', $request->status);
        }

        if ($request->filled('service_id')) {
            $query->where('contact_us.service_id', $request->service_id);
        }

        if ($request->filled('agent')) {
            if ($request->agent === 'unassigned') {
                $query->whereNull('contact_us.agent_id');
            } else {
                $query->where('contact_us.agent_id', $request->agent);
            }
        }

        if ($request->filled('date_from')) {
            $query->whereDate('contact_us.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('contact_us.created_at', '<=', $request->date_to);
        }

        $totalCount = $query->count();
        $contacts = $query->orderBy('contact_us.created_at', 'desc')->paginate(20)->withQueryString();

        $services = DB::table('services')
            ->whereNull('deleted_at')
            ->where('is_sub_service', 0)
            ->select('id', 'title_english')
            ->orderBy('title_english')
            ->get();

        $statusCounts = DB::table('contact_us')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $agentsList = DB::table('agents')
            ->whereNull('deleted_at')
            ->where('status', 'Active')
            ->select('id', 'full_name_en')
            ->orderBy('full_name_en')
            ->get();

        return view('crm::contact-us.index', compact('contacts', 'totalCount', 'services', 'statusCounts', 'agentsList'));
    }

    public function show($id)
    {
        $contact = DB::table('contact_us')
            ->leftJoin('services', 'contact_us.service_id', '=', 'services.id')
            ->leftJoin('agents', 'contact_us.agent_id', '=', 'agents.id')
            ->leftJoin('users', 'agents.user_id', '=', 'users.id')
            ->select(
                'contact_us.*',
                'services.title_english as service_name',
                'agents.full_name_en as agent_name',
                'agents.full_name_ar as agent_name_ar',
                'users.email as agent_email'
            )
            ->where('contact_us.id', $id)
            ->first();

        if (!$contact) {
            abort(404);
        }

        // Resolve the offer/project an inquiry-form submission came from. Looked up here
        // rather than joined, because the target table depends on related_type. Left null
        // when the item has since been deleted; the view says so rather than 404-ing.
        $contact->relatedTitle = null;
        $contact->relatedUrl = null;

        if ($contact->related_type && $contact->related_id) {
            $table = $contact->related_type === 'offer' ? 'offers' : 'projects';

            $related = DB::table($table)
                ->select('title_english', 'slug')
                ->where('id', $contact->related_id)
                ->first();

            if ($related) {
                $contact->relatedTitle = $related->title_english;
                $contact->relatedUrl = $contact->related_type === 'offer'
                    ? route('offers.show', $related->slug)
                    : route('projects.show', $related->slug);
            }
        }

        $agentsList = DB::table('agents')
            ->whereNull('deleted_at')
            ->where('status', 'Active')
            ->select('id', 'full_name_en')
            ->orderBy('full_name_en')
            ->get();

        $emailLogs = DB::table('contact_us_email_logs')
            ->leftJoin('users', 'contact_us_email_logs.user_id', '=', 'users.id')
            ->where('contact_us_email_logs.contact_us_id', $id)
            ->select(
                'contact_us_email_logs.*',
                'users.name as sent_by_name'
            )
            ->orderBy('contact_us_email_logs.created_at', 'desc')
            ->get();

        $comments = DB::table('contact_us_comments')
            ->leftJoin('users', 'contact_us_comments.user_id', '=', 'users.id')
            ->where('contact_us_comments.contact_us_id', $id)
            ->select(
                'contact_us_comments.*',
                'users.name as user_name'
            )
            ->orderBy('contact_us_comments.created_at', 'desc')
            ->get();

        return view('crm::contact-us.show', compact('contact', 'agentsList', 'emailLogs', 'comments'));
    }

    public function assignAgent(Request $request, $id)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
        ]);

        DB::table('contact_us')->where('id', $id)->update([
            'agent_id' => $request->agent_id,
            'status' => 'InProgress',
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Agent assigned and status set to In Progress.');
    }

    public function unassignAgent($id)
    {
        DB::table('contact_us')->where('id', $id)->update([
            'agent_id' => null,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Agent unassigned successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,InProgress,Done',
        ]);

        DB::table('contact_us')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:5000',
        ]);

        DB::table('contact_us')->where('id', $id)->update([
            'notes' => $request->notes,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Notes updated successfully.');
    }

    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:5000',
        ]);

        DB::table('contact_us_comments')->insert([
            'contact_us_id' => $id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function deleteComment($id)
    {
        $comment = DB::table('contact_us_comments')->where('id', $id)->first();

        if (!$comment) {
            abort(404);
        }

        DB::table('contact_us_comments')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    public function sendReply(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string|max:10000',
            'attachments.*' => 'nullable|file|max:10240',
            'link_urls.*' => 'nullable|url|max:500',
            'link_titles.*' => 'nullable|string|max:255',
        ]);

        $contact = DB::table('contact_us')->where('id', $id)->first();
        if (!$contact) {
            abort(404);
        }

        $recipientName = $contact->name ?? 'Customer';
        $originalSubject = $contact->subject ?? 'Your inquiry';

        $attachmentFiles = [];
        $attachmentNames = [];
        $tempDir = storage_path('app/temp_email_attachments');

        if ($request->hasFile('attachments')) {
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $originalName = $file->getClientOriginalName();
                    $storedPath = $file->move($tempDir, uniqid() . '_' . $originalName);
                    $attachmentFiles[] = $storedPath->getPathname();
                    $attachmentNames[] = $originalName;
                }
            }
        }

        $externalLinks = [];
        if ($request->has('link_urls')) {
            foreach ($request->link_urls as $index => $url) {
                if (!empty($url)) {
                    $externalLinks[] = [
                        'url' => $url,
                        'title' => $request->link_titles[$index] ?? '',
                    ];
                }
            }
        }

        $mail = Mail::to($contact->email);

        if ($contact->agent_id) {
            $agentEmail = DB::table('agents')
                ->leftJoin('users', 'agents.user_id', '=', 'users.id')
                ->where('agents.id', $contact->agent_id)
                ->value('users.email');

            if ($agentEmail) {
                $mail->cc($agentEmail);
            }
        }

        $mail->send(new ContactUsReplyMail(
            $request->subject,
            $request->body,
            $recipientName,
            $originalSubject,
            $attachmentFiles,
            $attachmentNames,
            $externalLinks
        ));

        foreach ($attachmentFiles as $path) {
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        DB::table('contact_us_email_logs')->insert([
            'contact_us_id' => $id,
            'user_id' => Auth::id(),
            'to_email' => $contact->email,
            'subject' => $request->subject,
            'body' => $request->body,
            'attachments' => count($attachmentNames) > 0 ? json_encode($attachmentNames) : null,
            'links' => count($externalLinks) > 0 ? json_encode($externalLinks) : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Reply email sent successfully.');
    }

    public function destroy($id)
    {
        DB::table('contact_us')->where('id', $id)->delete();

        return redirect()->route('crm-contact-us.index')->with('success', 'Contact message deleted successfully.');
    }
}
