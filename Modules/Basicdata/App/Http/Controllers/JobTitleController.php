<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\JobTitle;

class JobTitleController extends Controller
{
    protected $jobTitle;

    public function __construct(JobTitle $jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    /**
     * Display a listing of job titles
     */
    public function index()
    {
        $jobTitles = $this->jobTitle->list();
        
        return view('basicdata::jobtitles.index', [
            'jobTitles' => $jobTitles
        ]);
    }

    /**
     * Show the form for creating a new job title
     */
    public function create()
    {
        return view('basicdata::jobtitles.create');
    }

    /**
     * Store a newly created job title
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
        ]);

        JobTitle::create($data);

        return redirect()->route('jobtitle.index')->with('success', 'Job Title created successfully!');
    }

    /**
     * Show the form for editing job title
     */
    public function edit($id)
    {
        $jobTitle = JobTitle::findOrFail($id);
        
        return view('basicdata::jobtitles.edit', [
            'jobTitle' => $jobTitle
        ]);
    }

    /**
     * Update the specified job title
     */
    public function update(Request $request, $id)
    {
        $jobTitle = JobTitle::findOrFail($id);
        
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
        ]);

        $jobTitle->update($data);

        return redirect()->route('jobtitle.index')->with('success', 'Job Title updated successfully!');
    }

    /**
     * Soft delete the job title
     */
    public function destroy($id)
    {
        $jobTitle = JobTitle::findOrFail($id);
        $jobTitle->delete();

        return redirect()->route('jobtitle.index')->with('success', 'Job Title deleted successfully!');
    }

    /**
     * Display trashed job titles
     */
    public function trashed()
    {
        $jobTitles = $this->jobTitle->trashed();
        
        return view('basicdata::jobtitles.trashed', [
            'jobTitles' => $jobTitles
        ]);
    }

    /**
     * Restore trashed job title
     */
    public function restore($id)
    {
        $jobTitle = JobTitle::withTrashed()->findOrFail($id);
        $jobTitle->restore();

        return redirect()->route('jobtitle.trashed')->with('success', 'Job Title restored successfully!');
    }
}

