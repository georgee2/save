<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\JobCategory;

class JobCategoryController extends Controller
{
    protected $jobCategory;

    public function __construct(JobCategory $jobCategory)
    {
        $this->jobCategory = $jobCategory;
    }

    /**
     * Display a listing of job categories
     */
    public function index()
    {
        $jobCategories = $this->jobCategory->list();
        
        return view('basicdata::jobcategories.index', [
            'jobCategories' => $jobCategories
        ]);
    }

    /**
     * Show the form for creating a new job category
     */
    public function create()
    {
        return view('basicdata::jobcategories.create');
    }

    /**
     * Store a newly created job category
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'status' => 'required|in:Active,Not Active',
        ]);

        JobCategory::create($data);

        return redirect()->route('jobcategory.index')->with('success', 'Job Category created successfully!');
    }

    /**
     * Show the form for editing job category
     */
    public function edit($id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        
        return view('basicdata::jobcategories.edit', [
            'jobCategory' => $jobCategory
        ]);
    }

    /**
     * Update the specified job category
     */
    public function update(Request $request, $id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'status' => 'required|in:Active,Not Active',
        ]);

        $jobCategory->update($data);

        return redirect()->route('jobcategory.index')->with('success', 'Job Category updated successfully!');
    }

    /**
     * Soft delete the job category
     */
    public function destroy($id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->delete();

        return redirect()->route('jobcategory.index')->with('success', 'Job Category deleted successfully!');
    }

    /**
     * Display trashed job categories
     */
    public function trashed()
    {
        $jobCategories = $this->jobCategory->trashed();
        
        return view('basicdata::jobcategories.trashed', [
            'jobCategories' => $jobCategories
        ]);
    }

    /**
     * Restore trashed job category
     */
    public function restore($id)
    {
        $jobCategory = JobCategory::withTrashed()->findOrFail($id);
        $jobCategory->restore();

        return redirect()->route('jobcategory.trashed')->with('success', 'Job Category restored successfully!');
    }
}

