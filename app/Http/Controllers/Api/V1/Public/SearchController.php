<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Services\Api\GlobalSearchQueryService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(protected GlobalSearchQueryService $search)
    {
    }

    /**
     * Unified paginated search across projects/offers/interior/news. Each result
     * row carries its own `domain` so the app knows which detail endpoint to call
     * next (mirrors the domain+id pattern used by MenuItemsController::itemDetail).
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'required|string|min:1|max:255',
            'page' => 'nullable|integer|min:1',
            'page_size' => 'nullable|integer|min:1|max:100',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Search results fetched successfully',
            'data' => $this->search->paginate($request),
        ]);
    }
}
