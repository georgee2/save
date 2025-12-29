<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\EngineeringCategory;
use App\Models\OfferCategory;

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

        $view->with([
            'headerProjectCategories' => $headerProjectCategories,
            'headerOfferCategories' => $headerOfferCategories,
        ]);
    }
}

