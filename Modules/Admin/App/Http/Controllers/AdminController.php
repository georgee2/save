<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

// Import all models
use App\Models\Service;
use App\Models\Project;
use App\Models\Offer;
use App\Models\News;
use App\Models\Newscategory;
use App\Models\Team;
use App\Models\Partner;
use App\Models\Slider;
use App\Models\FAQ;
use App\Models\FeasibilityStudy;
use App\Models\User;
use App\Models\Showcase;
use App\Models\HomeBlock;
use App\Models\Card;
use App\Models\HomeFaq;
use App\Models\AboutFeature;
use App\Models\AboutCustomBlock;
use App\Models\ContactUs;
use App\Models\JobsPosting;
use App\Models\JobApplication;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get counts for all entities
        $stats = [
            // Main Content
            'services' => Service::whereNull('deleted_at')->count(),
            'services_published' => Service::whereNull('deleted_at')->where('publish_status', 0)->count(),
            'services_featured' => Service::whereNull('deleted_at')->where('home_feature_status', 0)->count(),
            
            'projects' => Project::whereNull('deleted_at')->count(),
            'projects_published' => Project::whereNull('deleted_at')->where('publish_status', 0)->count(),
            'projects_featured' => Project::whereNull('deleted_at')->where('home_status', 0)->count(),
            
            'offers' => Offer::whereNull('deleted_at')->count(),
            'offers_published' => Offer::whereNull('deleted_at')->where('publish_status', 0)->count(),
            'offers_featured' => Offer::whereNull('deleted_at')->where('home_status', 0)->count(),
            
            'news' => News::count(),
            'news_categories' => Newscategory::whereNull('deleted_at')->count(),
            
            'team_members' => Team::whereNull('deleted_at')->count(),
            'partners' => Partner::whereNull('deleted_at')->count(),
            'sliders' => Slider::whereNull('deleted_at')->count(),
            'sliders_active' => Slider::whereNull('deleted_at')->where('status', 1)->count(),
            
            'faqs' => FAQ::whereNull('deleted_at')->count(),
            'feasibility_studies' => FeasibilityStudy::count(),
            
            'users' => User::count(),
            'showcases' => Showcase::whereNull('deleted_at')->count(),
            'showcases_active' => Showcase::whereNull('deleted_at')->where('status', 1)->count(),
            
            'home_blocks' => HomeBlock::whereNull('deleted_at')->count(),
            'cards' => Card::whereNull('deleted_at')->count(),
            'home_faqs' => HomeFaq::whereNull('deleted_at')->count(),
            
            'about_features' => AboutFeature::whereNull('deleted_at')->count(),
            'about_custom_blocks' => AboutCustomBlock::whereNull('deleted_at')->count(),
            
            // Contact & Careers
            'contact_submissions' => ContactUs::count(),
            'contact_pending' => ContactUs::where('status', 'Pending')->count(),
            'jobs_postings' => JobsPosting::whereNull('deleted_at')->count(),
            'jobs_active' => JobsPosting::whereNull('deleted_at')->where('status', 'Publish')->count(),
            'job_applications' => JobApplication::count(),
            'job_applications_pending' => JobApplication::where('status', 'Received')->count(),
        ];
        
        // Get recent activity (last 30 days)
        $recentActivity = [
            'services' => Service::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'projects' => Project::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'offers' => Offer::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'news' => News::where('created_at', '>=', now()->subDays(30))->count(),
            'team_members' => Team::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
        ];
        
        // Get monthly data for charts (last 6 months)
        $monthlyData = $this->getMonthlyData();
        
        // Get category distribution
        $categoryDistribution = $this->getCategoryDistribution();
        
        // Get status distribution
        $statusDistribution = $this->getStatusDistribution();
        
        return view('admin::index', compact('stats', 'recentActivity', 'monthlyData', 'categoryDistribution', 'statusDistribution'));
    }
    
    /**
     * Get monthly data for the last 6 months
     */
    private function getMonthlyData()
    {
        $months = [];
        $services = [];
        $projects = [];
        $offers = [];
        $news = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            
            $services[] = Service::whereNull('deleted_at')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
                
            $projects[] = Project::whereNull('deleted_at')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
                
            $offers[] = Offer::whereNull('deleted_at')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
                
            $news[] = News::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
        }
        
        return [
            'months' => $months,
            'services' => $services,
            'projects' => $projects,
            'offers' => $offers,
            'news' => $news,
        ];
    }
    
    /**
     * Get category distribution for projects
     */
    private function getCategoryDistribution()
    {
        $categories = DB::table('projects')
            ->join('engineering_categories', 'projects.category_id', '=', 'engineering_categories.id')
            ->select('engineering_categories.title_english as category', DB::raw('count(*) as count'))
            ->whereNull('projects.deleted_at')
            ->groupBy('engineering_categories.id', 'engineering_categories.title_english')
            ->get();
            
        return [
            'labels' => $categories->pluck('category')->toArray(),
            'data' => $categories->pluck('count')->toArray(),
        ];
    }
    
    /**
     * Get status distribution
     */
    private function getStatusDistribution()
    {
        return [
            'services' => [
                'published' => Service::whereNull('deleted_at')->where('publish_status', 0)->count(),
                'unpublished' => Service::whereNull('deleted_at')->where('publish_status', 1)->count(),
            ],
            'projects' => [
                'published' => Project::whereNull('deleted_at')->where('publish_status', 0)->count(),
                'unpublished' => Project::whereNull('deleted_at')->where('publish_status', 1)->count(),
            ],
            'offers' => [
                'published' => Offer::whereNull('deleted_at')->where('publish_status', 0)->count(),
                'unpublished' => Offer::whereNull('deleted_at')->where('publish_status', 1)->count(),
            ],
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
