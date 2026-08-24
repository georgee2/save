<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Models\AboutInformation;
use App\Models\ContactInformation;
use App\Models\Project;
use App\Models\Team;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Used for about info
        $about = AboutInformation::firstOrFail();
        //used for location info
        $contact = ContactInformation::getContactInfo();
        //used for about stats
        $projects = Project::list();
        $teams = Team::list();
        $oldest_project_date = $projects->sortBy('created_at')->first()->created_at;
        //differ between now and oldest project with round to nearest years count
        $experience_years = round((time() - strtotime($oldest_project_date)) / 31536000, 0);
        $completed_projects = $projects->where('category_id', '=', 3)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'About Us fetched successfully',
            'data' => [
                'about_english' => $about->about_english,
                'about_arabic' => $about->about_arabic,
                'about_image' => $about->about_image,

                'mission_english' => $about->mission_english,
                'mission_arabic' => $about->mission_arabic,
                'mission_image' => $about->mission_image,

                'vision_english' => $about->vision_english,
                'vision_arabic' => $about->vision_arabic,
                'vision_image' => $about->vision_image,

                'values_english' => $about->values_english,
                'values_arabic' => $about->values_arabic,
                'values_points_english' => $about->values_points_english,
                'values_points_arabic' => $about->values_points_arabic,
                'values_image' => $about->values_image,

                'company_profile' => $about->company_profile,
                'page_cover_image' => $about->page_cover_image,

                'location_arabic' => $contact->location_text_arabic,
                'location_english' => $contact->location_text_english,
                'location_map' => $contact->location_map,
                'footer_bio_arabic' => $contact->footer_bio_arabic,
                'footer_bio_english' => $contact->footer_bio_english,

                'projects_count' => $projects->count(),
                'projects_completed_percentage' => round(($completed_projects/$projects->count())*100, 2),
                'projects_completed_count' => $completed_projects,
                'experience_years' => $experience_years,
                'team_count' => $teams->count(),
            ],
        ]);
    }
}
