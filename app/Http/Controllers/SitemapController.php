<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\Project;
use App\Models\Offer;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\OfferCategory;
use App\Models\OfferSubCategory;
use App\Models\Team;
use App\Models\Partner;
use App\Models\JobsPosting;
use App\Models\InteriorCategory;

class SitemapController extends Controller
{
    /**
     * Display the visual HTML sitemap page
     */
    public function html()
    {
        $services = Service::where('publish_status', 0)->whereNull('deleted_at')->orderBy('title_english')->get();

        $projectCategories = EngineeringCategory::whereNull('deleted_at')
            ->with(['subCategories' => function ($q) { $q->whereNull('deleted_at'); }])
            ->orderBy('title_english')->get();

        $offerCategories = OfferCategory::whereNull('deleted_at')
            ->with(['subCategories' => function ($q) { $q->whereNull('deleted_at'); }])
            ->orderBy('title_english')->get();

        $news = DB::table('news')->orderBy('created_at', 'desc')->limit(20)->get();

        $interiorCategories = InteriorCategory::whereNull('deleted_at')->orderBy('ordering')->get();

        $teamMembers = Team::whereNull('deleted_at')->get();

        $partners = Partner::where('partner_type', 'partner')->whereNull('deleted_at')->get();
        $branches = Partner::where('partner_type', 'branch')->whereNull('deleted_at')->get();

        $activeJobs = DB::table('jobs_postings')
            ->leftJoin('job_titles', 'jobs_postings.job_title_id', '=', 'job_titles.id')
            ->select('jobs_postings.id', 'job_titles.name_english as job_title_english', 'job_titles.name_arabic as job_title_arabic')
            ->where('jobs_postings.status', 'Publish')
            ->where('jobs_postings.registration_start_date', '<=', now())
            ->where('jobs_postings.registration_end_date', '>=', now())
            ->whereNull('jobs_postings.deleted_at')
            ->get();

        return view('sitemap.html', compact(
            'services', 'projectCategories', 'offerCategories',
            'news', 'teamMembers', 'partners', 'branches', 'activeJobs', 'interiorCategories'
        ));
    }

    /**
     * Generate the sitemap XML
     */
    public function index()
    {
        $urls = [];
        
        // Static Pages
        $urls[] = [
            'loc' => route('index'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0'
        ];
        
        $urls[] = [
            'loc' => route('about'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ];
        
        $urls[] = [
            'loc' => route('contact'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ];
        
        // Services
        $urls[] = [
            'loc' => route('services.index'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '0.9'
        ];
        
        $services = Service::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($services as $service) {
            $urls[] = [
                'loc' => route('services.show', $service->slug),
                'lastmod' => $service->updated_at ? $service->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        // Projects
        $urls[] = [
            'loc' => route('projects.index'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '0.9'
        ];
        
        $projects = Project::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($projects as $project) {
            $urls[] = [
                'loc' => route('projects.show', $project->slug),
                'lastmod' => $project->updated_at ? $project->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        // Project Categories
        $projectCategories = EngineeringCategory::whereNull('deleted_at')->get();
        foreach ($projectCategories as $category) {
            $urls[] = [
                'loc' => route('category.show', $category->slug),
                'lastmod' => $category->updated_at ? $category->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ];
        }
        
        // Project Subcategories
        $projectSubcategories = EngineeringSubCategory::whereNull('deleted_at')->get();
        foreach ($projectSubcategories as $subcategory) {
            $urls[] = [
                'loc' => route('subcategory.show', $subcategory->slug),
                'lastmod' => $subcategory->updated_at ? $subcategory->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ];
        }
        
        // Offers
        $urls[] = [
            'loc' => route('offers.index'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '0.9'
        ];
        
        $offers = Offer::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($offers as $offer) {
            $urls[] = [
                'loc' => route('offers.show', $offer->slug),
                'lastmod' => $offer->updated_at ? $offer->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        // Offer Categories
        $offerCategories = OfferCategory::whereNull('deleted_at')->get();
        foreach ($offerCategories as $category) {
            $urls[] = [
                'loc' => route('offers.category', $category->slug),
                'lastmod' => $category->updated_at ? $category->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ];
        }
        
        // Offer Subcategories
        $offerSubcategories = OfferSubCategory::whereNull('deleted_at')->get();
        foreach ($offerSubcategories as $subcategory) {
            $urls[] = [
                'loc' => route('offers.subcategory', $subcategory->slug),
                'lastmod' => $subcategory->updated_at ? $subcategory->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ];
        }
        
        // News/Blogs - No publish_status or deleted_at in news table
        $urls[] = [
            'loc' => route('blogs.index'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.9'
        ];
        
        $news = DB::table('news')->get();
            
        foreach ($news as $article) {
            if (!empty($article->slug)) {
                $urls[] = [
                    'loc' => route('blogs.show', $article->slug),
                    'lastmod' => $article->updated_at ? \Carbon\Carbon::parse($article->updated_at)->toAtomString() : now()->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6'
                ];
            }
        }
        
        // Team Pages
        $urls[] = [
            'loc' => route('team.index'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        ];
        
        $urls[] = [
            'loc' => route('team.board'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        ];
        
        $teamMembers = Team::whereNull('deleted_at')->get();
        foreach ($teamMembers as $member) {
            $urls[] = [
                'loc' => route('team.member', $member->id),
                'lastmod' => $member->updated_at ? $member->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ];
        }
        
        // Partners
        $urls[] = [
            'loc' => route('partners.index'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        ];
        
        $partners = Partner::where('partner_type', 'partner')
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($partners as $partner) {
            $urls[] = [
                'loc' => route('partners.show', $partner->id),
                'lastmod' => $partner->updated_at ? $partner->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ];
        }
        
        // Branches
        $urls[] = [
            'loc' => route('branches.index'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        ];
        
        $branches = Partner::where('partner_type', 'branch')
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($branches as $branch) {
            $urls[] = [
                'loc' => route('branches.show', $branch->id),
                'lastmod' => $branch->updated_at ? $branch->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ];
        }
        
        // Careers - uses 'status' enum ('Publish', 'Not Publish')
        $activeJobs = JobsPosting::where('status', 'Publish')
            ->where('registration_start_date', '<=', now())
            ->where('registration_end_date', '>=', now())
            ->whereNull('deleted_at')
            ->get();
            
        if ($activeJobs->count() > 0) {
            $urls[] = [
                'loc' => route('careers.index'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ];
            
            foreach ($activeJobs as $job) {
                $urls[] = [
                    'loc' => route('careers.show', $job->id),
                    'lastmod' => $job->updated_at ? $job->updated_at->toAtomString() : now()->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6'
                ];
            }
        }
        
        return response()->view('sitemap.index', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
