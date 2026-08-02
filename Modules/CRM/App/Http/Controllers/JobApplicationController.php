<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Staff-facing access to job applications.
 *
 * CVs live on the private `local` disk, so the only way to retrieve one is through
 * download() below, which runs behind the CRM's auth + staff + permission middleware.
 */
class JobApplicationController extends Controller
{
    /**
     * List submitted applications, newest first.
     */
    public function index()
    {
        $applications = DB::table('job_applications')
            ->leftJoin('jobs_postings', 'job_applications.job_id', '=', 'jobs_postings.id')
            ->leftJoin('job_titles', 'jobs_postings.job_title_id', '=', 'job_titles.id')
            ->select(
                'job_applications.*',
                'jobs_postings.code as job_code',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic'
            )
            ->orderBy('job_applications.created_at', 'desc')
            ->get();

        return view('crm::job-applications.index', [
            'applications' => $applications,
        ]);
    }

    /**
     * Stream a CV down to the browser under the applicant's original filename.
     */
    public function download($id)
    {
        $application = JobApplication::findOrFail($id);

        if (empty($application->resume) || ! Storage::disk('local')->exists($application->resume)) {
            abort(404);
        }

        return Storage::disk('local')->download(
            $application->resume,
            $application->resume_original_name ?: basename($application->resume)
        );
    }
}
