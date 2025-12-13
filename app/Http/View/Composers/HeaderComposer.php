<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Service;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\EngineeringCategory;
use App\Models\Showcase;
use App\Models\Portfolio;
use App\Models\News;
use App\Models\Newscategory;

class HeaderComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Get main active services with icons (not sub-services)
        $headerServices = Service::where('publish_status', 0)
            ->where('is_sub_service', 0)
            ->whereNull('service_id')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Check if there are any published projects
        $hasPublishedProjects = Project::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->exists();

        // Get engineering categories with icons for projects menu
        $headerProjectCategories = EngineeringCategory::whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Check if there are any published portfolios
        $hasPublishedPortfolios = Portfolio::where('status', 0)
            ->whereNull('deleted_at')
            ->exists();

        // Check if there are any blogs
        $hasBlogs = News::exists();

        // Get last 5 showcases
        $headerShowcases = Showcase::where('status', 'active')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        // Get last 5 portfolios
        $headerPortfolios = Portfolio::where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        // Get blog categories
        $headerBlogCategories = Newscategory::whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->get();

        $view->with([
            'headerServices' => $headerServices,
            'headerProjectCategories' => $headerProjectCategories,
            'hasPublishedProjects' => $hasPublishedProjects,
            'headerShowcases' => $headerShowcases,
            'headerPortfolios' => $headerPortfolios,
            'hasPublishedPortfolios' => $hasPublishedPortfolios,
            'headerBlogCategories' => $headerBlogCategories,
            'hasBlogs' => $hasBlogs,
        ]);
    }
}

