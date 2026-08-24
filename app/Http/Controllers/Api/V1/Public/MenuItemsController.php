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
use App\Models\Team;
use App\Models\ContactInformation;
use App\Services\Api\InteriorQueryService;
use App\Services\Api\NewsQueryService;
use App\Services\Api\OfferQueryService;
use App\Services\Api\ProjectQueryService;
use Illuminate\Http\Request;

class MenuItemsController extends Controller
{
    /** How many items each Home section previews - just enough for a home-screen row, not a full listing. */
    protected const HOME_SECTION_PREVIEW_SIZE = 10;

    /** How many projects the Home "latest completed" list includes. */
    protected const HOME_LATEST_COMPLETED_LIMIT = 10;

    public function __construct(
        protected ProjectQueryService $projects,
        protected OfferQueryService $offers,
        protected InteriorQueryService $interior,
        protected NewsQueryService $news,
    ) {
    }

    public function index()
    {
        $activeItems = collect();

        foreach (Menu::getActiveMenusByLocation('header') as $menu) {
            $activeItems = $activeItems->merge(
                $menu->items()->where('is_visible_mobile', 1)->get()
            );
        }

        //used for location info
        $contact = ContactInformation::getContactInfo();

        $social_links = [];
        if ($contact->whatsapp) {
            $social_links[] = [
                'platform' => 'WhatsApp',
                'icon' => 'fab fa-whatsapp',
                'url' => 'https://wa.me/'.$contact->whatsapp,
            ];
        }
        if ($contact->twitter) {
            $social_links[] = [
                'platform' => 'Twitter',
                'icon' => 'fab fa-twitter',
                'url' => $contact->twitter,
            ];
        }
        if ($contact->facebook) {
            $social_links[] = [
                'platform' => 'Facebook',
                'icon' => 'fab fa-facebook-f',
                'url' => $contact->facebook,
            ];
        }
        if ($contact->instagram) {
            $social_links[] = [
                'platform' => 'Instagram',
                'icon' => 'fab fa-instagram',
                'url' => $contact->instagram,
            ];
        }
        if ($contact->linkedin) {
            $social_links[] = [
                'platform' => 'LinkedIn',
                'icon' => 'fab fa-linkedin-in',
                'url' => $contact->linkedin,
            ];
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Menu Items fetched successfully',
            'social_links' => $social_links,
            'data' => $activeItems->values(),
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
        } elseif ($item->item_type === MenuItem::TYPE_DYNAMIC_NEWS) {
            // Unlike dynamic_query/category_with_subs, dynamic_news isn't pinned to a
            // category (App\Models\MenuItem::getDynamicChildren() always resolves it
            // to every category that has news) - it always means "all news".
            $resolved = ['domain' => 'news'];
        } elseif (in_array($item->item_type, [MenuItem::TYPE_DYNAMIC_QUERY, MenuItem::TYPE_CATEGORY_WITH_SUBS], true)) {
            $resolved = $this->resolveDynamic($item);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu item type is not a browsable content item',
            ], 404);
        }

        // The "Home" static item resolves to a set of preview sections instead of a
        // single browsable domain - handled entirely separately from the rest of this
        // method (other static-page cases are unaffected).
        if (\array_key_exists('sections', $resolved)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Home sections fetched successfully',
                'domain' => null,
                'sections' => $resolved['sections'],
                'dashboard' => $resolved['dashboard'],
                'latest' => $resolved['latest'],
                'data' => null,
                'filters' => null,
            ]);
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
            // News has no pinned-scope concept - always "all news", so no $constraints.
            'news' => [$this->news->paginate($request), $this->news->filterOptions()],
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

        if (!$id || !in_array($domain, ['projects', 'offers', 'interior', 'news'], true)) {
            return response()->json([
                'status' => 'error',
                'message' => 'domain (projects|offers|interior|news) and id are required',
            ], 422);
        }

        $data = match ($domain) {
            'projects' => $this->projects->detail((int) $id),
            'offers' => $this->offers->detail((int) $id, $request->emirate_id ? (int) $request->emirate_id : null),
            'interior' => $this->interior->detail((int) $id),
            'news' => $this->news->detail((int) $id),
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
        // Home handling: preview sections from the sibling dynamic menu items, plus
        // a company-stats dashboard and a latest-completed-projects list. Other
        // static-page cases (about, contact, ...) are handled below as before.
        if (strtolower(trim($item->title_english ?? '')) === 'home') {
            return [
                'domain' => null,
                'sections' => $this->buildHomeSections(),
                'dashboard' => $this->buildHomeDashboard(),
                'latest' => $this->projects->latestCompleted(self::HOME_LATEST_COMPLETED_LIMIT),
            ];
        }

        // Static News menu items are inconsistent in this system (route_name is
        // always 'blogs.index', but title varies - "News", "All News", ...), so this
        // matches on title containing "news" rather than on route_name, same
        // forgiving-by-title approach as Home above.
        if (str_contains(strtolower(trim($item->title_english ?? '')), 'news')) {
            return ['domain' => 'news'];
        }

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

    /**
     * One section per dynamic_query/category_with_subs item in the same active,
     * mobile-visible header menu that index() already exposes - each with a small
     * content preview. A dynamic item whose pinned scope has zero matching items is
     * dropped entirely rather than returned as an empty section. Static sibling
     * items (about, contact, ...) are not part of this step.
     */
    protected function buildHomeSections(): array
    {
        $previewRequest = new Request(['page_size' => self::HOME_SECTION_PREVIEW_SIZE, 'page' => 1]);
        $locale = app()->getLocale();

        $sections = [];

        foreach (Menu::getActiveMenusByLocation('header') as $menu) {
            $dynamicItems = $menu->items()
                ->where('is_visible_mobile', 1)
                ->whereIn('item_type', [MenuItem::TYPE_DYNAMIC_QUERY, MenuItem::TYPE_CATEGORY_WITH_SUBS])
                ->get();

            foreach ($dynamicItems as $dynamicItem) {
                $resolved = $this->resolveDynamic($dynamicItem);
                $domain = $resolved['domain'] ?? null;

                if ($domain === null) {
                    continue;
                }

                $constraints = [
                    'category_ids' => $resolved['category_ids'] ?? null,
                    'subcategory_ids' => $resolved['subcategory_ids'] ?? null,
                ];

                $paginator = match ($domain) {
                    'projects' => $this->projects->paginate($previewRequest, $constraints),
                    'offers' => $this->offers->paginate($previewRequest, $constraints),
                    'interior' => $this->interior->paginate($previewRequest, $constraints),
                };

                if ($paginator->total() === 0) {
                    continue;
                }

                $sections[] = [
                    'id' => $dynamicItem->id,
                    'title' => $locale === 'ar' ? $dynamicItem->title_arabic : $dynamicItem->title_english,
                    'domain' => $domain,
                    'total' => $paginator->total(),
                    'items' => $paginator->items(),
                ];
            }
        }

        return $sections;
    }

    /**
     * Company-wide stats for the Home dashboard. "Completed" and "engineers" have no
     * dedicated columns/relations in the schema - completed reuses the publish gate
     * (publish_status=0), and engineers is a headcount from the `teams` table
     * (staff members, unrelated to any specific project) filtered to job titles
     * containing "Engineer", not a per-project figure.
     */
    protected function buildHomeDashboard(): array
    {
        return [
            'years_of_experience' => $this->projects->yearsOfExperience(),
            'completed_projects_count' => $this->projects->completedCount(),
            'emirates_count' => $this->projects->emiratesCount(),
            'engineers_count' => Team::whereNull('deleted_at')
                ->whereHas('jobTitle', fn ($q) => $q->where('name_english', 'like', '%engineer%'))
                ->count(),
        ];
    }
}
