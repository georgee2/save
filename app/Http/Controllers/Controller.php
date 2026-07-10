<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Whether the request carries any user-applied listing filter (ignoring
     * pagination/sort). Used to distinguish an empty category page from an
     * empty *filtered* result, so we only soft-404 the former.
     */
    protected function listingHasActiveFilters(Request $request): bool
    {
        $filterKeys = [
            'emirate_id', 'category_id', 'subcategory_id', 'style_id', 'type_id',
            'sqft_min', 'sqft_max', 'sqm_min', 'sqm_max', 'price_min', 'price_max', 'keyword',
        ];

        return count(array_intersect(array_keys($request->query()), $filterKeys)) > 0;
    }
}
