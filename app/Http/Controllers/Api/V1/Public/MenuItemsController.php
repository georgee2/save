<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\InteriorCategory;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\OfferCategory;
use App\Models\OfferSubCategory;
use App\Services\Api\InteriorQueryService;
use App\Services\Api\OfferQueryService;
use App\Services\Api\ProjectQueryService;
use Illuminate\Http\Request;

class MenuItemsController extends Controller
{
    public function __construct(
        protected ProjectQueryService $projects,
        protected OfferQueryService $offers,
        protected InteriorQueryService $interior,
    ) {
    }

    public function index()
    {
        $activeHeader = Menu::getActiveMenusByLocation('header');

        $acitveItems = [];
        if ($activeHeader) {
            foreach ($activeHeader as $menu) {
                $acitveItems[] = $menu->items()->where('is_visible_mobile', 1)->select('id', 'menu_id', 'title_english', 'title_arabic', 'item_type')->get();
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Menu Items fetched successfully',
            'data' => $acitveItems,
        ]);
    }

    /**
     * Resolve a tapped menu item to its content: for items that point at a browsable
     * listing (static links to an index/category/subcategory page, or a dynamic_query /
     * category_with_subs item pinned to a query_source), returns the available filters
     * PLUS paginated data for that scope. For static items that point elsewhere (about,
     * contact, team, ...) there is no list to page through, so `data`/`filters` are null
     * and the app should just navigate using `route_name`/`url`.
     */
    public function itemRoute(Request $request)
    {
        $item = MenuItem::find($request->id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu Item not found',
            ], 404);
        }

        if ($item->item_type === MenuItem::TYPE_STATIC) {
            $resolved = $this->resolveStatic($item);
        } elseif (in_array($item->item_type, [MenuItem::TYPE_DYNAMIC_QUERY, MenuItem::TYPE_CATEGORY_WITH_SUBS], true)) {
            $resolved = $this->resolveDynamic($item);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu item type is not a browsable content item',
            ], 404);
        }

        $domain = $resolved['domain'] ?? null;

        if ($domain === null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Menu item resolved to a static page',
                'domain' => null,
                'route_name' => $item->route_name,
                'route_params' => $item->route_params,
                'url' => $item->url,
                'data' => null,
                'filters' => null,
            ]);
        }

        // Admin-pinned scope (dynamic_query/category_with_subs ids, or a slug resolved
        // from a static category/subcategory route) is a hard boundary: request-level
        // category_id/subcategory_id can only narrow within it, never escape it - each
        // *QueryService enforces that itself.
        $constraints = [
            'category_ids' => $resolved['category_ids'] ?? null,
            'subcategory_ids' => $resolved['subcategory_ids'] ?? null,
        ];

        [$data, $filters] = match ($domain) {
            'projects' => [$this->projects->paginate($request, $constraints), $this->projects->filterOptions($constraints)],
            'offers' => [$this->offers->paginate($request, $constraints), $this->offers->filterOptions($constraints)],
            'interior' => [$this->interior->paginate($request, $constraints), $this->interior->filterOptions($constraints)],
        };

        return response()->json([
            'status' => 'success',
            'message' => 'Menu Item data fetched successfully',
            'domain' => $domain,
            'data' => $data,
            'filters' => $filters,
        ]);
    }

    /**
     * Single dispatcher for "get the full detail row for this card": the app already
     * knows the domain from a prior itemRoute/list call, so it just sends domain + id
     * here rather than needing to know which per-domain endpoint to call.
     */
    public function itemDetail(Request $request)
    {
        $domain = $request->domain;
        $id = $request->id;

        if (!$id || !in_array($domain, ['projects', 'offers', 'interior'], true)) {
            return response()->json([
                'status' => 'error',
                'message' => 'domain (projects|offers|interior) and id are required',
            ], 422);
        }

        $data = match ($domain) {
            'projects' => $this->projects->detail((int) $id),
            'offers' => $this->offers->detail((int) $id, $request->emirate_id ? (int) $request->emirate_id : null),
            'interior' => $this->interior->detail((int) $id),
        };

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => ucfirst($domain).' item not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Details fetched successfully',
            'domain' => $domain,
            'data' => $data,
        ]);
    }

    /**
     * Map a `static` item's route_name (+ optional slug in route_params) to a content
     * domain and pinned scope. Only listing-style routes resolve to a domain; everything
     * else (about, contact, team, careers, ...) resolves to domain => null.
     */
    protected function resolveStatic(MenuItem $item): array
    {
        $params = $item->route_params ?? [];
        $slug = $params['slug'] ?? ($params[0] ?? null);

        switch ($item->route_name) {
            case 'projects.index':
                return ['domain' => 'projects'];

            case 'category.show':
                $category = $slug ? EngineeringCategory::where('slug', $slug)->whereNull('deleted_at')->first() : null;

                return $category
                    ? ['domain' => 'projects', 'category_ids' => [$category->id]]
                    : ['domain' => null];

            case 'subcategory.show':
                $subcategory = $slug ? EngineeringSubCategory::where('slug', $slug)->whereNull('deleted_at')->first() : null;

                return $subcategory
                    ? ['domain' => 'projects', 'category_ids' => [$subcategory->category_id], 'subcategory_ids' => [$subcategory->id]]
                    : ['domain' => null];

            case 'offers.index':
                return ['domain' => 'offers'];

            case 'offers.category':
                $category = $slug ? OfferCategory::where('slug', $slug)->whereNull('deleted_at')->first() : null;

                return $category
                    ? ['domain' => 'offers', 'category_ids' => [$category->id]]
                    : ['domain' => null];

            case 'offers.subcategory':
                $subcategory = $slug ? OfferSubCategory::where('slug', $slug)->whereNull('deleted_at')->first() : null;

                return $subcategory
                    ? ['domain' => 'offers', 'category_ids' => [$subcategory->category_id], 'subcategory_ids' => [$subcategory->id]]
                    : ['domain' => null];

            case 'interior.index':
                return ['domain' => 'interior'];

            case 'interior.category':
                $category = null;
                if ($slug !== null) {
                    $category = InteriorCategory::where('slug', $slug)->whereNull('deleted_at')->first();
                    if (!$category && is_numeric($slug)) {
                        $category = InteriorCategory::find($slug);
                    }
                }

                return $category
                    ? ['domain' => 'interior', 'category_ids' => [$category->id]]
                    : ['domain' => null];

            default:
                return ['domain' => null];
        }
    }

    /**
     * Map a dynamic_query/category_with_subs item's query_source + admin-pinned
     * category/subcategory ids to a content domain and scope. Interior has no
     * subcategory concept, so its pinned subcategory ids (if any) are ignored.
     */
    protected function resolveDynamic(MenuItem $item): array
    {
        if (!in_array($item->query_source, [MenuItem::QUERY_SOURCE_PROJECTS, MenuItem::QUERY_SOURCE_OFFERS, MenuItem::QUERY_SOURCE_INTERIOR], true)) {
            return ['domain' => null];
        }

        return [
            'domain' => $item->query_source,
            'category_ids' => $item->query_category_ids ?: null,
            'subcategory_ids' => $item->query_source === MenuItem::QUERY_SOURCE_INTERIOR ? null : ($item->query_subcategory_ids ?: null),
        ];
    }
}
