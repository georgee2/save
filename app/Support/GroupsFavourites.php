<?php

namespace App\Support;

use App\Models\Project;
use App\Models\Offer;
use App\Models\InteriorDesignGallery;

/**
 * Resolves a flat collection of Favourite rows into eager-loaded, display-ready
 * groups (projects / offers / interiors), dropping rows whose target item no
 * longer exists. Shared by the public and account favourites controllers.
 */
trait GroupsFavourites
{
    protected function groupFavourites($favourites): array
    {
        $projectIds = $favourites->where('item_type', 'project')->pluck('item_id');
        $offerIds = $favourites->where('item_type', 'offer')->pluck('item_id');
        $interiorIds = $favourites->where('item_type', 'interior')->pluck('item_id');

        $projects = Project::whereIn('id', $projectIds)
            ->with(['category', 'subcategory', 'emirate', 'specifications'])
            ->get()
            ->keyBy('id');

        $offers = Offer::whereIn('id', $offerIds)
            ->with(['category', 'subcategory', 'prices' => function($q) { $q->where('status', 0); }, 'prices.emirate', 'currency', 'specifications'])
            ->get()
            ->keyBy('id');

        $interiors = InteriorDesignGallery::whereIn('id', $interiorIds)
            ->with(['category', 'projectStyle'])
            ->get()
            ->keyBy('id');

        return [
            'projects' => $favourites->where('item_type', 'project')->map(function ($fav) use ($projects) {
                $fav->itemData = $projects->get($fav->item_id);
                return $fav;
            })->filter(fn($fav) => $fav->itemData !== null),

            'offers' => $favourites->where('item_type', 'offer')->map(function ($fav) use ($offers) {
                $fav->itemData = $offers->get($fav->item_id);
                if ($fav->itemData && $fav->emirate_id) {
                    $fav->selectedPrice = $fav->itemData->prices->firstWhere('emirate_id', $fav->emirate_id);
                }
                return $fav;
            })->filter(fn($fav) => $fav->itemData !== null),

            'interiors' => $favourites->where('item_type', 'interior')->map(function ($fav) use ($interiors) {
                $fav->itemData = $interiors->get($fav->item_id);
                return $fav;
            })->filter(fn($fav) => $fav->itemData !== null),
        ];
    }
}
