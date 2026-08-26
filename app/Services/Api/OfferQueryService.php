<?php

namespace App\Services\Api;

use App\Models\Emirate;
use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\OfferSpecification;
use App\Models\OfferSubCategory;
use App\Models\OffersPrices\OfferPrice;
use App\Models\ProjectStyle;
use App\Models\ProjectType;
use App\Models\Specification;
use App\Services\Api\Concerns\ResolvesMediaUrls;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Shared offer listing logic for the mobile API: the plain /offers endpoint and
 * MenuItemsController::itemRoute both go through here.
 *
 * Mirrors App\Http\Controllers\OffersController's applyFilters()/applySorting()/
 * processOffers() (web).
 */
class OfferQueryService
{
    use ResolvesMediaUrls;

    /**
     * @param  array{category_ids?: array, subcategory_ids?: array}  $constraints  Admin-pinned
     *         menu-item scope; a hard boundary the same way ProjectQueryService applies it.
     */
    public function query(Request $request, array $constraints = []): Builder
    {
        $query = Offer::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->with([
                'category', 'subcategory', 'style', 'type', 'currency', 'specifications.specification',
                'prices' => fn ($q) => $q->where('status', 0), 'prices.emirate',
            ])
            ->withCount('images');

        $this->applyPinnedConstraints($query, $request, $constraints);
        $this->applyFilters($query, $request, $constraints);
        $this->applySorting($query, $request);

        return $query;
    }

    /**
     * Cheap existence check for a pinned scope (no request-level filters) - used by
     * MenuItemsController::index() to drop menu items with nothing to show, without
     * paying for a full paginated fetch just to throw the rows away.
     */
    public function hasAny(array $constraints = []): bool
    {
        return $this->query(new Request(), $constraints)->exists();
    }

    public function paginate(Request $request, array $constraints = []): LengthAwarePaginator
    {
        $perPage = (int) ($request->page_size ?? 20);
        $page = (int) ($request->page ?? 1);

        $offers = $this->query($request, $constraints)->paginate($perPage, ['*'], 'page', $page);

        return $this->withComputedFields($offers, $request->emirate_id);
    }

    /**
     * Full detail for one offer: the publish gate + the whole relation set
     * (03_CONTENT_API.md) + absolute media URLs + the emirate price selector data
     * (all active prices, default_price, and selected_price if ?emirate_id= is given).
     *
     * Note: same scope limitation as ProjectQueryService::detail() - floor/amenity/
     * building-component icons are left as raw relative paths for now.
     */
    public function detail(int $id, ?int $selectedEmirateId = null): ?array
    {
        $offer = Offer::where('id', $id)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->with([
                'category', 'subcategory', 'currency', 'style', 'type',
                'images',
                'specifications.specification',
                'prices' => fn ($q) => $q->where('status', 0), 'prices.emirate',
                'floors' => fn ($q) => $q->whereNull('deleted_at')->with([
                    'buildingComponent', 'floorComponent', 'specifications.specification', 'amenities.amenity',
                ]),
                'feasibilityStudies' => fn ($q) => $q->whereNull('deleted_at')->where('status', 'Active')->with([
                    'currency', 'emirate', 'buildingComponents.buildingComponent',
                    'lengthComponents.lengthComponent', 'incomeComponents.incomeComponent',
                    'constructionCosts.substationRoom', 'constructionCosts.pumpsRoom', 'projectCost',
                ]),
            ])
            ->first();

        if (!$offer) {
            return null;
        }

        $data = $offer->toArray();

        foreach (['main_image', 'cover_image', 'page_image', 'site_image', 'plan_2d_image', 'plan_3d_image'] as $field) {
            $data[$field] = $this->mediaUrl($offer->{$field});
        }

        foreach (['category', 'subcategory', 'style', 'type'] as $rel) {
            if (!empty($data[$rel]['icon'])) {
                $data[$rel]['icon'] = $this->mediaUrl($data[$rel]['icon']);
            }
            if (!empty($data[$rel]['image'])) {
                $data[$rel]['image'] = $this->mediaUrl($data[$rel]['image']);
            }
        }

        if (!empty($data['images'])) {
            foreach ($data['images'] as &$image) {
                $image['image'] = $this->mediaUrl($image['image']);
            }
            unset($image);
        }

        if (!empty($data['specifications'])) {
            foreach ($data['specifications'] as &$spec) {
                if (!empty($spec['specification']['icon'])) {
                    $spec['specification']['icon'] = $this->mediaUrl($spec['specification']['icon']);
                }
            }
            unset($spec);
        }

        $primaryEmirate = Emirate::getPrimary();
        $primaryEmirateId = $primaryEmirate?->id;
        $activePrices = $offer->prices->where('status', 0);

        $selectedPrice = $selectedEmirateId ? $activePrices->where('emirate_id', $selectedEmirateId)->first() : null;

        $defaultPrice = $primaryEmirateId ? $activePrices->where('emirate_id', $primaryEmirateId)->first() : null;
        if (!$defaultPrice) {
            $defaultPrice = $activePrices->sortBy(fn ($price) => $price->emirate?->title_english ?? '')->first();
        }

        $data['selected_price'] = $selectedPrice ? $selectedPrice->toArray() : null;
        $data['default_price'] = $defaultPrice ? $defaultPrice->toArray() : null;
        $data['default_emirate_id'] = $primaryEmirateId;
        $data['all_prices'] = $activePrices->sortBy(fn ($price) => $price->emirate?->title_english ?? '')->values()->toArray();

        return $data;
    }

    /**
     * Available filter option lists, narrowed to the pinned scope when one is given.
     */
    public function filterOptions(array $constraints = []): array
    {
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;
        $pinnedSubcategoryIds = $constraints['subcategory_ids'] ?? null;

        $categories = OfferCategory::whereNull('deleted_at')
            ->when($pinnedCategoryIds, fn ($q) => $q->whereIn('id', $pinnedCategoryIds))
            ->whereHas('offers', fn ($q) => $q->where('publish_status', 0)->whereNull('deleted_at'))
            ->orderBy('title_english')
            ->get();

        $subcategories = OfferSubCategory::whereNull('deleted_at')
            ->when($pinnedSubcategoryIds, fn ($q) => $q->whereIn('id', $pinnedSubcategoryIds))
            ->when(!$pinnedSubcategoryIds && $pinnedCategoryIds, fn ($q) => $q->whereIn('category_id', $pinnedCategoryIds))
            ->whereHas('offers', fn ($q) => $q->where('publish_status', 0)->whereNull('deleted_at'))
            ->orderBy('title_english')
            ->get();

        return [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'styles' => ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get(),
            'types' => ProjectType::whereNull('deleted_at')->orderBy('name_english')->get(),
            'emirates' => Emirate::whereNull('deleted_at')->orderBy('title_english')->get(),
            'sqft_range' => $this->numericRange($this->scopedOffers($constraints), 'sqft'),
            'sqm_range' => $this->numericRange($this->scopedOffers($constraints), 'sqm'),
            'price_range' => $this->priceRange($constraints),
            'specifications' => $this->specificationsWithValues($constraints),
        ];
    }

    /**
     * A fresh, pinned-scope-aware base query over published offers - reused by the
     * range/specification-value lookups below.
     */
    protected function scopedOffers(array $constraints): Builder
    {
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;
        $pinnedSubcategoryIds = $constraints['subcategory_ids'] ?? null;

        return Offer::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->when($pinnedCategoryIds, fn ($q) => $q->whereIn('category_id', $pinnedCategoryIds))
            ->when($pinnedSubcategoryIds, fn ($q) => $q->whereIn('subcategory_id', $pinnedSubcategoryIds));
    }

    /**
     * MIN/MAX of $column across the given query, as-is from the DB - null when there
     * are no matching rows.
     */
    protected function numericRange(Builder $query, string $column): array
    {
        $row = $query->selectRaw("MIN({$column}) as min_value, MAX({$column}) as max_value")->first();

        return [
            'min' => $row?->min_value !== null ? (float) $row->min_value : null,
            'max' => $row?->max_value !== null ? (float) $row->max_value : null,
        ];
    }

    /**
     * MIN/MAX active price across matching offers (price lives on offer_prices, not
     * on offers itself) - real DB values, no sentinel/guessed bounds.
     */
    protected function priceRange(array $constraints): array
    {
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;
        $pinnedSubcategoryIds = $constraints['subcategory_ids'] ?? null;

        $row = OfferPrice::where('status', 0)
            ->whereHas('offer', function ($q) use ($pinnedCategoryIds, $pinnedSubcategoryIds) {
                $q->where('publish_status', 0)->whereNull('deleted_at')
                    ->when($pinnedCategoryIds, fn ($qq) => $qq->whereIn('category_id', $pinnedCategoryIds))
                    ->when($pinnedSubcategoryIds, fn ($qq) => $qq->whereIn('subcategory_id', $pinnedSubcategoryIds));
            })
            ->selectRaw('MIN(price) as min_value, MAX(price) as max_value')
            ->first();

        return [
            'min' => $row?->min_value !== null ? (float) $row->min_value : null,
            'max' => $row?->max_value !== null ? (float) $row->max_value : null,
        ];
    }

    /**
     * Each specification + the distinct values actually used by matching offers - a
     * specification with zero matching values in this scope is dropped entirely.
     */
    protected function specificationsWithValues(array $constraints): array
    {
        $valueColumn = app()->getLocale() === 'ar' ? 'value_arabic' : 'value_english';
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;
        $pinnedSubcategoryIds = $constraints['subcategory_ids'] ?? null;

        return Specification::whereNull('deleted_at')
            ->orderBy('title_english')
            ->get()
            ->map(function (Specification $spec) use ($valueColumn, $pinnedCategoryIds, $pinnedSubcategoryIds) {
                $values = OfferSpecification::where('specification_id', $spec->id)
                    ->whereNull('deleted_at')
                    ->whereHas('offer', function ($q) use ($pinnedCategoryIds, $pinnedSubcategoryIds) {
                        $q->where('publish_status', 0)->whereNull('deleted_at')
                            ->when($pinnedCategoryIds, fn ($qq) => $qq->whereIn('category_id', $pinnedCategoryIds))
                            ->when($pinnedSubcategoryIds, fn ($qq) => $qq->whereIn('subcategory_id', $pinnedSubcategoryIds));
                    })
                    ->distinct()
                    ->pluck($valueColumn)
                    ->filter(fn ($value) => $value !== null && $value !== '')
                    // Natural sort, not DB string order: values are free-text (often
                    // numeric, e.g. Bathrooms), and "1,10,11,2,3" reads wrong to a user.
                    ->sort(fn ($a, $b) => strnatcasecmp($a, $b))
                    ->values();

                $spec->setAttribute('values', $values);

                return $spec;
            })
            ->filter(fn (Specification $spec) => $spec->values->isNotEmpty())
            ->values()
            ->all();
    }

    protected function applyPinnedConstraints(Builder $query, Request $request, array $constraints): void
    {
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;
        $pinnedSubcategoryIds = $constraints['subcategory_ids'] ?? null;

        if (!empty($pinnedCategoryIds)) {
            $query->whereIn('category_id', $pinnedCategoryIds);

            if ($request->filled('category_id') && in_array((string) $request->category_id, array_map('strval', $pinnedCategoryIds), true)) {
                $query->where('category_id', $request->category_id);
            }
        }

        if (!empty($pinnedSubcategoryIds)) {
            $query->whereIn('subcategory_id', $pinnedSubcategoryIds);

            if ($request->filled('subcategory_id') && in_array((string) $request->subcategory_id, array_map('strval', $pinnedSubcategoryIds), true)) {
                $query->where('subcategory_id', $request->subcategory_id);
            }
        }
    }

    protected function applyFilters(Builder $query, Request $request, array $constraints): void
    {
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;
        $pinnedSubcategoryIds = $constraints['subcategory_ids'] ?? null;

        if (empty($pinnedCategoryIds) && $request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if (empty($pinnedSubcategoryIds) && $request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        if ($request->filled('style_id')) {
            $query->where('style_id', $request->style_id);
        }

        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        if ($request->filled('sqft_min')) {
            $query->where('sqft', '>=', $request->sqft_min);
        }
        if ($request->filled('sqft_max')) {
            $query->where('sqft', '<=', $request->sqft_max);
        }

        if ($request->filled('sqm_min')) {
            $query->where('sqm', '>=', $request->sqm_min);
        }
        if ($request->filled('sqm_max')) {
            $query->where('sqm', '<=', $request->sqm_max);
        }

        if ($request->filled('emirate_id')) {
            $emirateId = $request->emirate_id;
            $query->whereHas('prices', function ($q) use ($emirateId) {
                $q->where('emirate_id', $emirateId)->where('status', 0);
            });
        }

        if ($request->filled('price_min') || $request->filled('price_max')) {
            $priceMin = $request->price_min;
            $priceMax = $request->price_max;
            $emirateId = $request->emirate_id;

            $query->whereHas('prices', function ($q) use ($priceMin, $priceMax, $emirateId) {
                $q->where('status', 0);

                if ($emirateId) {
                    $q->where('emirate_id', $emirateId);
                }
                if ($priceMin) {
                    $q->where('price', '>=', $priceMin);
                }
                if ($priceMax) {
                    $q->where('price', '<=', $priceMax);
                }
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_english', 'like', "%{$search}%")
                    ->orWhere('title_arabic', 'like', "%{$search}%")
                    ->orWhere('seo_tags', 'like', "%{$search}%");
            });
        }
    }

    protected function applySorting(Builder $query, Request $request): void
    {
        switch ($request->get('sortby', 'newest')) {
            case 'oldest':
                $query->orderBy('offers.created_at', 'ASC');
                break;
            case 'price_low':
                $query->orderByRaw('(SELECT MIN(price) FROM offer_prices WHERE offer_prices.offer_id = offers.id AND offer_prices.status = 0) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('(SELECT MAX(price) FROM offer_prices WHERE offer_prices.offer_id = offers.id AND offer_prices.status = 0) DESC');
                break;
            case 'area_low':
                $query->orderBy('offers.sqft', 'ASC');
                break;
            case 'area_high':
                $query->orderBy('offers.sqft', 'DESC');
                break;
            case 'newest':
            default:
                $query->orderBy('offers.created_at', 'DESC');
                break;
        }
    }

    /**
     * Mirrors OffersController::processOffers (web): video/image counts + default_price
     * selection (selected emirate -> primary emirate -> first available active price).
     */
    protected function withComputedFields(LengthAwarePaginator $offers, $selectedEmirateId = null): LengthAwarePaginator
    {
        $primaryEmirate = Emirate::getPrimary();
        $primaryEmirateId = $primaryEmirate?->id;

        return $offers->through(function (Offer $offer) use ($selectedEmirateId, $primaryEmirateId) {
            $videoCount = 0;
            if (!empty($offer->video_url)) $videoCount++;
            if (!empty($offer->tour_url)) $videoCount++;
            $offer->video_count = $videoCount;
            $offer->total_images = $offer->images_count + 1;

            $activePrices = $offer->prices->where('status', 0);
            $offer->default_price = null;

            if ($selectedEmirateId) {
                $offer->default_price = $activePrices->where('emirate_id', $selectedEmirateId)->first();
            }
            if (!$offer->default_price && $primaryEmirateId) {
                $offer->default_price = $activePrices->where('emirate_id', $primaryEmirateId)->first();
            }
            if (!$offer->default_price) {
                $offer->default_price = $activePrices
                    ->sortBy(fn ($price) => $price->emirate?->title_english ?? '')
                    ->first();
            }

            return $offer;
        });
    }
}
