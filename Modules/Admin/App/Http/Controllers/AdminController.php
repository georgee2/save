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
use App\Models\InteriorDesignGallery;
use App\Models\Certificate;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\PageBanner;
use App\Models\Role;
use App\Models\ActivityLog;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\OfferCategory;
use App\Models\OfferSubCategory;
use App\Models\InteriorCategory;

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
            'services_unpublished' => Service::whereNull('deleted_at')->where('publish_status', 1)->count(),
            'services_featured' => Service::whereNull('deleted_at')->where('home_feature_status', 0)->count(),
            'services_trashed' => Service::onlyTrashed()->count(),
            
            'projects' => Project::whereNull('deleted_at')->count(),
            'projects_published' => Project::whereNull('deleted_at')->where('publish_status', 0)->count(),
            'projects_unpublished' => Project::whereNull('deleted_at')->where('publish_status', 1)->count(),
            'projects_featured' => Project::whereNull('deleted_at')->where('home_status', 0)->count(),
            'projects_trashed' => Project::onlyTrashed()->count(),
            
            'offers' => Offer::whereNull('deleted_at')->count(),
            'offers_published' => Offer::whereNull('deleted_at')->where('publish_status', 0)->count(),
            'offers_unpublished' => Offer::whereNull('deleted_at')->where('publish_status', 1)->count(),
            'offers_featured' => Offer::whereNull('deleted_at')->where('home_status', 0)->count(),
            'offers_trashed' => Offer::onlyTrashed()->count(),
            
            // Interior Design Galleries
            'interior_galleries' => InteriorDesignGallery::whereNull('deleted_at')->count(),
            'interior_galleries_published' => InteriorDesignGallery::whereNull('deleted_at')->where('publish_status', 1)->count(),
            'interior_galleries_featured' => InteriorDesignGallery::whereNull('deleted_at')->where('home_status', 1)->count(),
            'interior_galleries_trashed' => InteriorDesignGallery::onlyTrashed()->count(),
            
            // News
            'news' => News::count(),
            'news_categories' => Newscategory::whereNull('deleted_at')->count(),
            
            // Team & Partners
            'team_members' => Team::whereNull('deleted_at')->count(),
            'team_board_members' => Team::whereNull('deleted_at')->where('is_board_director', 1)->count(),
            'partners' => Partner::whereNull('deleted_at')->count(),
            
            // Sliders & Home Content
            'sliders' => Slider::whereNull('deleted_at')->count(),
            'sliders_active' => Slider::whereNull('deleted_at')->where('status', 0)->count(),
            'sliders_inactive' => Slider::whereNull('deleted_at')->where('status', 1)->count(),
            
            'showcases' => Showcase::whereNull('deleted_at')->count(),
            'showcases_active' => Showcase::whereNull('deleted_at')->where('status', 0)->count(),
            
            'home_blocks' => HomeBlock::whereNull('deleted_at')->count(),
            'cards' => Card::whereNull('deleted_at')->count(),
            'home_faqs' => HomeFaq::whereNull('deleted_at')->count(),
            
            // About Page
            'about_features' => AboutFeature::whereNull('deleted_at')->count(),
            'about_features_active' => AboutFeature::whereNull('deleted_at')->where('status', 0)->count(),
            'about_custom_blocks' => AboutCustomBlock::whereNull('deleted_at')->count(),
            'about_custom_blocks_active' => AboutCustomBlock::whereNull('deleted_at')->where('status', 0)->count(),
            
            // Certificates
            'certificates' => Certificate::whereNull('deleted_at')->count(),
            'certificates_active' => Certificate::whereNull('deleted_at')->where('publish_status', 1)->count(),
            
            // Page Banners
            'page_banners' => PageBanner::whereNull('deleted_at')->count(),
            
            // Menus
            'menus' => Menu::whereNull('deleted_at')->count(),
            'menus_active' => Menu::whereNull('deleted_at')->where('is_active', 1)->count(),
            'menu_items' => MenuItem::whereNull('deleted_at')->count(),
            
            // FAQs
            'faqs' => FAQ::whereNull('deleted_at')->count(),
            'feasibility_studies' => FeasibilityStudy::count(),
            
            // Contact & Careers
            'contact_submissions' => ContactUs::count(),
            'contact_pending' => ContactUs::where('status', 'Pending')->count(),
            'contact_replied' => ContactUs::where('status', 'Replied')->count(),
            'jobs_postings' => JobsPosting::whereNull('deleted_at')->count(),
            'jobs_active' => JobsPosting::whereNull('deleted_at')->where('status', 'Publish')->count(),
            'job_applications' => JobApplication::count(),
            'job_applications_pending' => JobApplication::where('status', 'Received')->count(),
            'job_applications_reviewed' => JobApplication::where('status', 'Reviewed')->count(),
            
            // Users & Roles
            'users' => User::count(),
            'roles' => Role::count(),
            'roles_active' => Role::where('is_active', 1)->count(),
            
            // Activity Logs
            'activity_logs' => ActivityLog::count(),
            'activity_logs_today' => ActivityLog::whereDate('created_at', today())->count(),
            'activity_logs_week' => ActivityLog::where('created_at', '>=', now()->subDays(7))->count(),
            
            // Categories (Basic Data)
            'engineering_categories' => EngineeringCategory::whereNull('deleted_at')->count(),
            'engineering_subcategories' => EngineeringSubCategory::whereNull('deleted_at')->count(),
            'offer_categories' => OfferCategory::whereNull('deleted_at')->count(),
            'offer_subcategories' => OfferSubCategory::whereNull('deleted_at')->count(),
            'interior_categories' => InteriorCategory::whereNull('deleted_at')->count(),
        ];
        
        // Get recent activity (last 30 days)
        $recentActivity = [
            'services' => Service::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'projects' => Project::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'offers' => Offer::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'interior_galleries' => InteriorDesignGallery::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'news' => News::where('created_at', '>=', now()->subDays(30))->count(),
            'team_members' => Team::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'contact_submissions' => ContactUs::where('created_at', '>=', now()->subDays(30))->count(),
            'job_applications' => JobApplication::where('created_at', '>=', now()->subDays(30))->count(),
        ];
        
        // Get weekly activity (last 7 days)
        $weeklyActivity = [
            'services' => Service::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(7))->count(),
            'projects' => Project::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(7))->count(),
            'offers' => Offer::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(7))->count(),
            'news' => News::where('created_at', '>=', now()->subDays(7))->count(),
        ];
        
        // Get monthly data for charts (last 6 months)
        $monthlyData = $this->getMonthlyData();
        
        // Get category distribution
        $categoryDistribution = $this->getCategoryDistribution();
        
        // Get status distribution
        $statusDistribution = $this->getStatusDistribution();
        
        // Get offers category distribution
        $offersCategoryDistribution = $this->getOffersCategoryDistribution();
        
        // Get recent activity logs
        $recentLogs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Get top content creators
        $topCreators = $this->getTopContentCreators();
        
        return view('admin::index', compact(
            'stats', 
            'recentActivity', 
            'weeklyActivity',
            'monthlyData', 
            'categoryDistribution', 
            'statusDistribution',
            'offersCategoryDistribution',
            'recentLogs',
            'topCreators'
        ));
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
        $interiorGalleries = [];
        
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
                
            $interiorGalleries[] = InteriorDesignGallery::whereNull('deleted_at')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
        }
        
        return [
            'months' => $months,
            'services' => $services,
            'projects' => $projects,
            'offers' => $offers,
            'news' => $news,
            'interior_galleries' => $interiorGalleries,
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
            ->orderBy('count', 'desc')
            ->limit(8)
            ->get();
            
        return [
            'labels' => $categories->pluck('category')->toArray(),
            'data' => $categories->pluck('count')->toArray(),
        ];
    }
    
    /**
     * Get category distribution for offers
     */
    private function getOffersCategoryDistribution()
    {
        $categories = DB::table('offers')
            ->join('offer_categories', 'offers.category_id', '=', 'offer_categories.id')
            ->select('offer_categories.title_english as category', DB::raw('count(*) as count'))
            ->whereNull('offers.deleted_at')
            ->groupBy('offer_categories.id', 'offer_categories.title_english')
            ->orderBy('count', 'desc')
            ->limit(8)
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
            'interior_galleries' => [
                'published' => InteriorDesignGallery::whereNull('deleted_at')->where('publish_status', 1)->count(),
                'unpublished' => InteriorDesignGallery::whereNull('deleted_at')->where('publish_status', 0)->count(),
            ],
        ];
    }
    
    /**
     * Get top content creators
     */
    private function getTopContentCreators()
    {
        return ActivityLog::select('user_id', 'user_name', DB::raw('count(*) as actions_count'))
            ->whereNotNull('user_id')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('user_id', 'user_name')
            ->orderBy('actions_count', 'desc')
            ->limit(5)
            ->get();
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
