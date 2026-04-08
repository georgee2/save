<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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
use App\Models\InteriorDesignGallery;

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
     * Generate the sitemap XML with dual-language (EN/AR) hreflang annotations
     */
    public function index()
    {
        $urls = [];

        $addUrl = function ($routeName, $params, $lastmod, $changefreq, $priority) use (&$urls) {
            $baseUrl = route($routeName, $params);
            $urls[] = [
                'loc_en' => LaravelLocalization::getLocalizedURL('en', $baseUrl),
                'loc_ar' => LaravelLocalization::getLocalizedURL('ar', $baseUrl),
                'lastmod' => $lastmod,
                'changefreq' => $changefreq,
                'priority' => $priority,
            ];
        };

        // Static Pages
        $addUrl('index', [], now()->toAtomString(), 'daily', '1.0');
        $addUrl('about', [], now()->toAtomString(), 'monthly', '0.8');
        $addUrl('contact', [], now()->toAtomString(), 'monthly', '0.8');

        // Services
        $addUrl('services.index', [], now()->toAtomString(), 'weekly', '0.9');
        $services = Service::where('publish_status', 0)->whereNull('deleted_at')->get();
        foreach ($services as $service) {
            $addUrl('services.show', $service->slug, $service->updated_at ? $service->updated_at->toAtomString() : now()->toAtomString(), 'weekly', '0.7');
        }

        // Projects
        $addUrl('projects.index', [], now()->toAtomString(), 'weekly', '0.9');
        $projects = Project::where('publish_status', 0)->whereNull('deleted_at')->get();
        foreach ($projects as $project) {
            $addUrl('projects.show', $project->slug, $project->updated_at ? $project->updated_at->toAtomString() : now()->toAtomString(), 'weekly', '0.7');
        }

        // Project Categories
        foreach (EngineeringCategory::whereNull('deleted_at')->get() as $category) {
            $addUrl('category.show', $category->slug, $category->updated_at ? $category->updated_at->toAtomString() : now()->toAtomString(), 'weekly', '0.6');
        }

        // Project Subcategories
        foreach (EngineeringSubCategory::whereNull('deleted_at')->get() as $subcategory) {
            $addUrl('subcategory.show', $subcategory->slug, $subcategory->updated_at ? $subcategory->updated_at->toAtomString() : now()->toAtomString(), 'weekly', '0.6');
        }

        // Offers
        $addUrl('offers.index', [], now()->toAtomString(), 'weekly', '0.9');
        $offers = Offer::where('publish_status', 0)->whereNull('deleted_at')->get();
        foreach ($offers as $offer) {
            $addUrl('offers.show', $offer->slug, $offer->updated_at ? $offer->updated_at->toAtomString() : now()->toAtomString(), 'weekly', '0.7');
        }

        // Offer Categories
        foreach (OfferCategory::whereNull('deleted_at')->get() as $category) {
            $addUrl('offers.category', $category->slug, $category->updated_at ? $category->updated_at->toAtomString() : now()->toAtomString(), 'weekly', '0.6');
        }

        // Offer Subcategories
        foreach (OfferSubCategory::whereNull('deleted_at')->get() as $subcategory) {
            $addUrl('offers.subcategory', $subcategory->slug, $subcategory->updated_at ? $subcategory->updated_at->toAtomString() : now()->toAtomString(), 'weekly', '0.6');
        }

        // Interior Design
        $addUrl('interior.index', [], now()->toAtomString(), 'weekly', '0.8');
        foreach (InteriorCategory::whereNull('deleted_at')->get() as $cat) {
            $addUrl('interior.category', $cat->slug, $cat->updated_at ? $cat->updated_at->toAtomString() : now()->toAtomString(), 'weekly', '0.6');
        }

        // News/Blogs
        $addUrl('blogs.index', [], now()->toAtomString(), 'daily', '0.9');
        $news = DB::table('news')->get();
        foreach ($news as $article) {
            if (!empty($article->slug)) {
                $addUrl('blogs.show', $article->slug, $article->updated_at ? \Carbon\Carbon::parse($article->updated_at)->toAtomString() : now()->toAtomString(), 'monthly', '0.6');
            }
        }

        // Team Pages
        $addUrl('team.index', [], now()->toAtomString(), 'monthly', '0.7');
        $addUrl('team.board', [], now()->toAtomString(), 'monthly', '0.7');
        foreach (Team::whereNull('deleted_at')->get() as $member) {
            $addUrl('team.member', $member->id, $member->updated_at ? $member->updated_at->toAtomString() : now()->toAtomString(), 'monthly', '0.5');
        }

        // Partners
        $addUrl('partners.index', [], now()->toAtomString(), 'monthly', '0.7');
        foreach (Partner::where('partner_type', 'partner')->whereNull('deleted_at')->get() as $partner) {
            $addUrl('partners.show', $partner->id, $partner->updated_at ? $partner->updated_at->toAtomString() : now()->toAtomString(), 'monthly', '0.5');
        }

        // Branches
        $addUrl('branches.index', [], now()->toAtomString(), 'monthly', '0.7');
        foreach (Partner::where('partner_type', 'branch')->whereNull('deleted_at')->get() as $branch) {
            $addUrl('branches.show', $branch->id, $branch->updated_at ? $branch->updated_at->toAtomString() : now()->toAtomString(), 'monthly', '0.5');
        }

        // Careers
        $activeJobs = JobsPosting::where('status', 'Publish')
            ->where('registration_start_date', '<=', now())
            ->where('registration_end_date', '>=', now())
            ->whereNull('deleted_at')
            ->get();

        if ($activeJobs->count() > 0) {
            $addUrl('careers.index', [], now()->toAtomString(), 'weekly', '0.8');
            foreach ($activeJobs as $job) {
                $addUrl('careers.show', $job->id, $job->updated_at ? $job->updated_at->toAtomString() : now()->toAtomString(), 'weekly', '0.6');
            }
        }

        return response()->view('sitemap.index', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
