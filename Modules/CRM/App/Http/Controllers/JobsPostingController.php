<?php

namespace Modules\CRM\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\JobsPosting;
use App\Models\JobTitle;
use App\Models\JobCategory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class JobsPostingController extends Controller
{
    protected $jobsPosting;

    public function __construct(JobsPosting $jobsPosting)
    {
        $this->jobsPosting = $jobsPosting;
    }

    /**
     * Display a listing of jobs postings
     */
    public function index()
    {
        $jobsPostings = $this->jobsPosting->list();
        
        return view('crm::jobs-postings.index', [
            'jobsPostings' => $jobsPostings
        ]);
    }

    /**
     * Show the form for creating a new job posting
     */
    public function create()
    {
        $jobTitles = JobTitle::whereNull('deleted_at')->get();
        $jobCategories = JobCategory::whereNull('deleted_at')->where('status', 'Active')->get();
        
        return view('crm::jobs-postings.create', [
            'jobTitles' => $jobTitles,
            'jobCategories' => $jobCategories
        ]);
    }

    /**
     * Store a newly created job posting
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'job_title_id' => 'required|exists:job_titles,id',
            'job_category_id' => 'required|exists:job_categories,id',
            'job_type' => 'required|in:Contract,Full Time,Intern,Hybrid,Remotely,Part-time',
            'salary' => 'nullable|numeric|min:0',
            'show_salary' => 'required|boolean',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after_or_equal:registration_start_date',
            'job_description_en' => 'required|string',
            'job_description_ar' => 'required|string',
            'requirements_en' => 'nullable|string',
            'requirements_ar' => 'nullable|string',
            'responsibilities_en' => 'nullable|string',
            'responsibilities_ar' => 'nullable|string',
            'status' => 'required|in:Publish,Not Publish',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Generate unique code
        $data['code'] = JobsPosting::generateCode();

        // Handle icon upload - resize to 100x100
        if ($request->hasFile('icon')) {
            $iconFile = $request->file('icon');
            $image = Image::make($iconFile)->resize(100, 100)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/jobs/icons/' . $imageName, (string) $image);
            $data['icon'] = "/uploads/jobs/icons/{$imageName}";
        }

        JobsPosting::create($data);

        return redirect()->route('jobs-posting.index')->with('success', 'Job Posting created successfully!');
    }

    /**
     * Display the specified job posting
     */
    public function show($id)
    {
        $jobPosting = JobsPosting::findWithRelations($id);
        
        if (!$jobPosting) {
            return redirect()->route('jobs-posting.index')->with('error', 'Job Posting not found!');
        }
        
        return view('crm::jobs-postings.show', [
            'jobPosting' => $jobPosting
        ]);
    }

    /**
     * Show the form for editing job posting
     */
    public function edit($id)
    {
        $jobPosting = JobsPosting::findOrFail($id);
        $jobTitles = JobTitle::whereNull('deleted_at')->get();
        $jobCategories = JobCategory::whereNull('deleted_at')->where('status', 'Active')->get();
        
        return view('crm::jobs-postings.edit', [
            'jobPosting' => $jobPosting,
            'jobTitles' => $jobTitles,
            'jobCategories' => $jobCategories
        ]);
    }

    /**
     * Update the specified job posting
     */
    public function update(Request $request, $id)
    {
        $jobPosting = JobsPosting::findOrFail($id);
        
        $data = $request->validate([
            'job_title_id' => 'required|exists:job_titles,id',
            'job_category_id' => 'required|exists:job_categories,id',
            'job_type' => 'required|in:Contract,Full Time,Intern,Hybrid,Remotely,Part-time',
            'salary' => 'nullable|numeric|min:0',
            'show_salary' => 'required|boolean',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after_or_equal:registration_start_date',
            'job_description_en' => 'required|string',
            'job_description_ar' => 'required|string',
            'requirements_en' => 'nullable|string',
            'requirements_ar' => 'nullable|string',
            'responsibilities_en' => 'nullable|string',
            'responsibilities_ar' => 'nullable|string',
            'status' => 'required|in:Publish,Not Publish',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle icon upload - resize to 100x100
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($jobPosting->icon) {
                Storage::disk('public')->delete(ltrim($jobPosting->icon, '/'));
            }
            
            $iconFile = $request->file('icon');
            $image = Image::make($iconFile)->resize(100, 100)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/jobs/icons/' . $imageName, (string) $image);
            $data['icon'] = "/uploads/jobs/icons/{$imageName}";
        }

        $jobPosting->update($data);

        return redirect()->route('jobs-posting.index')->with('success', 'Job Posting updated successfully!');
    }

    /**
     * Soft delete the job posting
     */
    public function destroy($id)
    {
        $jobPosting = JobsPosting::findOrFail($id);
        $jobPosting->delete();

        return redirect()->route('jobs-posting.index')->with('success', 'Job Posting deleted successfully!');
    }

    /**
     * Display trashed job postings
     */
    public function trashed()
    {
        $jobsPostings = $this->jobsPosting->trashed();
        
        return view('crm::jobs-postings.trashed', [
            'jobsPostings' => $jobsPostings
        ]);
    }

    /**
     * Restore trashed job posting
     */
    public function restore($id)
    {
        $jobPosting = JobsPosting::withTrashed()->findOrFail($id);
        $jobPosting->restore();

        return redirect()->route('jobs-posting.trashed')->with('success', 'Job Posting restored successfully!');
    }
}

