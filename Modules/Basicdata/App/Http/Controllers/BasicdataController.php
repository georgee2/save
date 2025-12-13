<?php

namespace Modules\Basicdata\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

// Import all models
use App\Models\ProjectType;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\ProjectStyle;
use App\Models\Amenity;
use App\Models\BuildingComponent;
use App\Models\FloorComponent;
use App\Models\IncomeComponent;
use App\Models\LengthComponent;
use App\Models\Currency;
use App\Models\Specification;
use App\Models\SubstationRoom;
use App\Models\PumpsRoom;
use App\Models\FeasibilityStudyComponent;
use App\Models\PortfolioType;
use App\Models\JobTitle;
use App\Models\JobCategory;
use App\Models\Rank;

class BasicdataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get counts for all entities
        $stats = [
            // Project Related
            'project_types' => ProjectType::whereNull('deleted_at')->count(),
            'engineering_categories' => EngineeringCategory::whereNull('deleted_at')->count(),
            'engineering_subcategories' => EngineeringSubCategory::whereNull('deleted_at')->count(),
            'project_styles' => ProjectStyle::whereNull('deleted_at')->count(),
            
            // Components
            'amenities' => Amenity::whereNull('deleted_at')->count(),
            'building_components' => BuildingComponent::whereNull('deleted_at')->count(),
            'floor_components' => FloorComponent::whereNull('deleted_at')->count(),
            'income_components' => IncomeComponent::whereNull('deleted_at')->count(),
            'length_components' => LengthComponent::whereNull('deleted_at')->count(),
            
            // Financial & Technical
            'currencies' => Currency::whereNull('deleted_at')->count(),
            'specifications' => Specification::whereNull('deleted_at')->count(),
            'substation_rooms' => SubstationRoom::whereNull('deleted_at')->count(),
            'pumps_rooms' => PumpsRoom::whereNull('deleted_at')->count(),
            'feasibility_components' => FeasibilityStudyComponent::whereNull('deleted_at')->count(),
            
            // Portfolio & HR
            'portfolio_types' => PortfolioType::whereNull('deleted_at')->count(),
            'job_titles' => JobTitle::whereNull('deleted_at')->count(),
            'job_categories' => JobCategory::whereNull('deleted_at')->count(),
            'ranks' => Rank::whereNull('deleted_at')->count(),
        ];
        
        // Get recent activity (last 30 days)
        $recentActivity = [
            'project_types' => ProjectType::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'engineering_categories' => EngineeringCategory::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'building_components' => BuildingComponent::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'amenities' => Amenity::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
            'specifications' => Specification::whereNull('deleted_at')->where('created_at', '>=', now()->subDays(30))->count(),
        ];
        
        // Get monthly data for charts (last 6 months)
        $monthlyData = $this->getMonthlyData();
        
        // Get category distribution
        $categoryDistribution = $this->getCategoryDistribution();
        
        // Get component types distribution
        $componentDistribution = $this->getComponentDistribution();
        
        return view('basicdata::index', compact('stats', 'recentActivity', 'monthlyData', 'categoryDistribution', 'componentDistribution'));
    }
    
    /**
     * Get monthly data for the last 6 months
     */
    private function getMonthlyData()
    {
        $months = [];
        $projectTypes = [];
        $categories = [];
        $components = [];
        $amenities = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            
            $projectTypes[] = ProjectType::whereNull('deleted_at')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
                
            $categories[] = EngineeringCategory::whereNull('deleted_at')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
                
            $components[] = BuildingComponent::whereNull('deleted_at')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
                
            $amenities[] = Amenity::whereNull('deleted_at')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
        }
        
        return [
            'months' => $months,
            'project_types' => $projectTypes,
            'categories' => $categories,
            'components' => $components,
            'amenities' => $amenities,
        ];
    }
    
    /**
     * Get category distribution
     */
    private function getCategoryDistribution()
    {
        $categories = DB::table('engineering_categories')
            ->select('title_english as category', DB::raw('count(*) as count'))
            ->whereNull('deleted_at')
            ->groupBy('id', 'title_english')
            ->get();
            
        return [
            'labels' => $categories->pluck('category')->toArray(),
            'data' => $categories->pluck('count')->toArray(),
        ];
    }
    
    /**
     * Get component types distribution
     */
    private function getComponentDistribution()
    {
        return [
            'labels' => ['Building', 'Floor', 'Income', 'Length', 'Feasibility'],
            'data' => [
                BuildingComponent::whereNull('deleted_at')->count(),
                FloorComponent::whereNull('deleted_at')->count(),
                IncomeComponent::whereNull('deleted_at')->count(),
                LengthComponent::whereNull('deleted_at')->count(),
                FeasibilityStudyComponent::whereNull('deleted_at')->count(),
            ],
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('basicdata::create');
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
        return view('basicdata::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('basicdata::edit');
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
