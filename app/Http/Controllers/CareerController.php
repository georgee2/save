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
            'cover_letter' => 'nullable|string',
        ]);
        
        // Handle resume upload
        if ($request->hasFile('resume')) {
            $resumeFile = $request->file('resume');
            $resumeName = time() . '_' . $resumeFile->getClientOriginalName();
            $resumePath = $resumeFile->storeAs('uploads/resumes', $resumeName, 'public');
            $data['resume'] = '/' . $resumePath;
        }
        
        // Add job_id and default status
        $data['job_id'] = $id;
        $data['status'] = 'Received';
        
        // Create application
        JobApplication::create($data);
        
        $successMessage = App::getLocale() == 'en'
            ? 'Your application has been submitted successfully! We will contact you soon.'
            : 'تم تقديم طلبك بنجاح! سنتواصل معك قريباً.';
        
        return back()->with('success', $successMessage);
    }
}

