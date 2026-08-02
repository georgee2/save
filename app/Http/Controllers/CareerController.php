<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobsPosting;
use App\Models\JobApplication;
use App\Models\PageBanner;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use App\Support\FormGuard;

class CareerController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Get published jobs with valid registration dates using query builder for joins
        $jobs = DB::table('jobs_postings')
            ->leftJoin('job_titles', 'jobs_postings.job_title_id', '=', 'job_titles.id')
            ->leftJoin('job_categories', 'jobs_postings.job_category_id', '=', 'job_categories.id')
            ->select(
                'jobs_postings.*',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'job_categories.name_english as job_category_english',
                'job_categories.name_arabic as job_category_arabic'
            )
            ->where('jobs_postings.status', 'Publish')
            ->whereDate('jobs_postings.registration_start_date', '<=', $today)
            ->whereDate('jobs_postings.registration_end_date', '>=', $today)
            ->whereNull('jobs_postings.deleted_at')
            ->orderBy('jobs_postings.created_at', 'desc')
            ->paginate(9);
        
        // Get page banner for careers page
        $pageBanner = PageBanner::getByTarget('careers');
        
        return view('pages.careers.index', compact('jobs', 'pageBanner'));
    }
    
    public function show($id)
    {
        $today = Carbon::today();
        
        // Get single job posting with valid dates
        $job = DB::table('jobs_postings')
            ->leftJoin('job_titles', 'jobs_postings.job_title_id', '=', 'job_titles.id')
            ->leftJoin('job_categories', 'jobs_postings.job_category_id', '=', 'job_categories.id')
            ->select(
                'jobs_postings.*',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'job_categories.name_english as job_category_english',
                'job_categories.name_arabic as job_category_arabic'
            )
            ->where('jobs_postings.id', $id)
            ->where('jobs_postings.status', 'Publish')
            ->whereDate('jobs_postings.registration_start_date', '<=', $today)
            ->whereDate('jobs_postings.registration_end_date', '>=', $today)
            ->whereNull('jobs_postings.deleted_at')
            ->first();
        
        if (!$job) {
            abort(404);
        }
        
        // Get related jobs (same category, excluding current job)
        $relatedJobs = DB::table('jobs_postings')
            ->leftJoin('job_titles', 'jobs_postings.job_title_id', '=', 'job_titles.id')
            ->leftJoin('job_categories', 'jobs_postings.job_category_id', '=', 'job_categories.id')
            ->select(
                'jobs_postings.*',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'job_categories.name_english as job_category_english',
                'job_categories.name_arabic as job_category_arabic'
            )
            ->where('jobs_postings.job_category_id', $job->job_category_id)
            ->where('jobs_postings.id', '!=', $job->id)
            ->where('jobs_postings.status', 'Publish')
            ->whereDate('jobs_postings.registration_start_date', '<=', $today)
            ->whereDate('jobs_postings.registration_end_date', '>=', $today)
            ->whereNull('jobs_postings.deleted_at')
            ->limit(3)
            ->get();
        
        // Get page banner for careers page (for job detail page as well)
        $pageBanner = PageBanner::getByTarget('careers');
        
        return view('pages.careers.job', compact('job', 'relatedJobs', 'pageBanner'));
    }
    
    /**
     * Store job application
     */
    public function apply(Request $request, $id)
    {
        // Honeypot + signed time-trap. A bot signal gets the same success message a real
        // application would, so it learns nothing; a stale page gets a visible message.
        // Errors go through session flash, not withErrors, because this page renders
        // per-field @error blocks only and would swallow a bag-level message.
        if ($reason = FormGuard::tripped($request)) {
            if ($reason->isBot()) {
                return back()->with('success', App::getLocale() == 'en'
                    ? 'Your application has been submitted successfully! We will contact you soon.'
                    : 'تم تقديم طلبك بنجاح! سنتواصل معك قريباً.');
            }

            // The redirect drops the uploaded file, so the message says to re-attach it.
            return back()->withInput()->with('error', __('lang.form_expired_with_file'));
        }

        $today = Carbon::today();
        
        // Verify job exists and is accepting applications
        $job = DB::table('jobs_postings')
            ->where('id', $id)
            ->where('status', 'Publish')
            ->whereDate('registration_start_date', '<=', $today)
            ->whereDate('registration_end_date', '>=', $today)
            ->whereNull('deleted_at')
            ->first();
        
        if (!$job) {
            return back()->with('error', App::getLocale() == 'en' 
                ? 'This job is no longer accepting applications.' 
                : 'هذه الوظيفة لم تعد تقبل التقديمات.');
        }
        
        // Validate request
        $data = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        // Store the CV on the private `local` disk, never the public one: these files carry
        // applicant PII and anything under storage/app/public is web-reachable via the
        // public/storage symlink. The name is generated server-side from a MIME-derived
        // extension so a client filename like "cv.php.pdf" cannot survive into the path.
        if ($request->hasFile('resume')) {
            $resumeFile = $request->file('resume');
            $data['resume'] = $resumeFile->storeAs(
                'resumes',
                Str::uuid() . '.' . $resumeFile->extension(),
                'local'
            );
            $data['resume_original_name'] = $resumeFile->getClientOriginalName();
        }
        
        // Add job_id, default status, and attribution so abuse is traceable
        $data['job_id'] = $id;
        $data['status'] = 'Received';
        $data['ip_address'] = $request->ip();
        $data['user_agent'] = Str::limit((string) $request->userAgent(), 250, '');
        
        // Create application
        JobApplication::create($data);
        
        $successMessage = App::getLocale() == 'en'
            ? 'Your application has been submitted successfully! We will contact you soon.'
            : 'تم تقديم طلبك بنجاح! سنتواصل معك قريباً.';
        
        return back()->with('success', $successMessage);
    }
}

