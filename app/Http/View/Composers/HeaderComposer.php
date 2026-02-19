<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\EngineeringCategory;
use App\Models\OfferCategory;
use App\Models\ContactInformation;
use App\Models\Service;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // Get the header menu with fallback logic:
        // 1. If primary menu is active, use it
        // 2. If primary is inactive, use the last active custom menu (for header location)
        $headerMenu = Menu::getHeaderMenu();
        $headerMenuItems = $headerMenu ? $headerMenu->getHierarchicalItems() : collect();
        
        // Check if we're using primary or custom menu (for debugging/display purposes)
        $isUsingPrimaryMenu = $headerMenu ? $headerMenu->is_primary : false;
        // Get engineering categories with their subcategories for projects menu
        $headerProjectCategories = EngineeringCategory::with(['subCategories' => function($query) {
            $query->whereNull('deleted_at')->orderBy('created_at', 'DESC');
        }])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Get offer categories with their subcategories for offers menu
        $headerOfferCategories = OfferCategory::with(['subCategories' => function($query) {
            $query->whereNull('deleted_at')->orderBy('created_at', 'DESC');
        }])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Get contact information for footer
        $footerContactInfo = ContactInformation::getContactInfo();

        // Get news categories with their news items for header dropdown
        $headerNewsCategories = DB::table('newscategories')
            ->select(
                'newscategories.id',
                'newscategories.name_english',
                'newscategories.name_arabic'
            )
            ->whereNull('newscategories.deleted_at')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('news')
                    ->whereColumn('news.category_code', 'newscategories.id');
            })
            ->orderBy('newscategories.name_english', 'ASC')
            ->get();

        // Get main services with their sub-services for services menu
        $headerServices = Service::with(['subServices' => function($query) {
            $query->where('publish_status', 0)
                  ->orderBy('created_at', 'ASC');
        }])
            ->where('is_sub_service', 0)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'ASC')
            ->get();

        // Check if there are active job postings for careers menu visibility
        $today = Carbon::today();
        $hasActiveJobs = DB::table('jobs_postings')
            ->where('status', 'Publish')
            ->whereDate('registration_start_date', '<=', $today)
            ->whereDate('registration_end_date', '>=', $today)
            ->whereNull('deleted_at')
            ->exists();

        // Get footer menus
        $footerQuickLinksMenu = Menu::getFooterQuickLinksMenu();
        $footerQuickLinksItems = $footerQuickLinksMenu ? $footerQuickLinksMenu->getHierarchicalItems() : collect();
        
        $footerCompanyMenu = Menu::getFooterCompanyMenu();
        $footerCompanyItems = $footerCompanyMenu ? $footerCompanyMenu->getHierarchicalItems() : collect();

        $view->with([
            'headerProjectCategories' => $headerProjectCategories,
            'headerOfferCategories' => $headerOfferCategories,
            'footerContactInfo' => $footerContactInfo,
            'headerNewsCategories' => $headerNewsCategories,
            'headerServices' => $headerServices,
            'hasActiveJobs' => $hasActiveJobs,
            // Menu variables (renamed for clarity)
            'headerMenu' => $headerMenu,
            'headerMenuItems' => $headerMenuItems,
            'isUsingPrimaryMenu' => $isUsingPrimaryMenu,
            // Keep old variable names for backward compatibility
            'primaryMenu' => $headerMenu,
            'primaryMenuItems' => $headerMenuItems,
            // Footer menus
            'footerQuickLinksMenu' => $footerQuickLinksMenu,
            'footerQuickLinksItems' => $footerQuickLinksItems,
            'footerCompanyMenu' => $footerCompanyMenu,
            'footerCompanyItems' => $footerCompanyItems,
        ]);
    }
}

