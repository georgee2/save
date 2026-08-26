<?php

namespace App\Services\Api;

use App\Models\Emirate;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\Project;
use App\Models\ProjectSpecification;
use App\Models\ProjectStyle;
use App\Models\ProjectType;
use App\Models\Specification;
use App\Services\Api\Concerns\ResolvesMediaUrls;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Shared project listing logic for the mobile API: the plain /projects endpoint and
 * MenuItemsController::itemRoute (dynamic_query / category_with_subs / static category
 * items) both go through here, so filters/sorting/publish-gate never drift between them.
 *
 * Mirrors App\Http\Controllers\ProjectsController's applyFilters()/applySorting() (web).
 */
class ProjectQueryService
{
    use ResolvesMediaUrls;

    /**
     * @param  array{category_ids?: array, subcategory_ids?: array}  $constraints  Admin-pinned
     *         menu-item scope. When present, it's a hard boundary: request-level
     *         category_id/subcategory_id can only narrow within it, never escape it.
     */
    public function query(Request $request, array $constraints = []): Builder
    {
        $query = Project::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->with([
                'category', 'subcategory', 'style',
                // When filtering by specification_id, only load the matched spec on each
                // result - otherwise every result's full (unrelated) spec sheet shows up
                // alongside it, which reads as "the filter is wrong" even though the
                // whereHas() match in applyFilters() below is accurate.
                'specifications' => function ($q) use ($request) {
                    $q->with('specification');

                    if ($request->filled('specification_id')) {
                        $q->where('specification_id', $request->specification_id);

                        if ($request->filled('specification_value')) {
                            $value = $request->specification_value;
                            $q->where(function ($sub) use ($value) {
                                $sub->where('value_english', 'like', "%{$value}%")
                                    ->orWhere('value_arabic', 'like', "%{$value}%");
                            });
                        }
                    }
                },
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

        return $this->query($request, $constraints)
            ->paginate($perPage, ['*'], 'page', $page)
            ->through(function (Project $project) {
                $videoCount = 0;
                if (!empty($project->video_url)) $videoCount++;
                if (!empty($project->tour_url)) $videoCount++;
                $project->video_count = $videoCount;
                $project->total_images = $project->images_count + 1;

                return $project;
            });
    }

    /**
     * Years since the oldest project record still in the system. Deliberately NOT
     * gated by publish_status - "years of experience" is about how long since the
     * first project was ever added, even if that particular project never got
     * published/completed. Soft-deleted rows are excluded since they don't really
     * "exist" anymore.
     */
    public function yearsOfExperience(): int
    {
        $oldest = Project::whereNull('deleted_at')->oldest('created_at')->first();

        return $oldest ? (int) $oldest->created_at->diffInYears(now()) : 0;
    }

    /**
     * "Completed" has no dedicated status column on projects - publish_status=0 is
     * used as the closest real signal, same publish gate used everywhere else.
     */
    public function completedCount(): int
    {
        return Project::where('publish_status', 0)->whereNull('deleted_at')->count();
    }

    /**
     * Distinct emirates with at least one published project.
     */
    public function emiratesCount(): int
    {
        return Project::where('publish_status', 0)->whereNull('deleted_at')
            ->whereNotNull('emirate_id')
            ->distinct()
            ->count('emirate_id');
    }

    /**
     * Brief cards for the most recently added published ("completed") projects -
     * same shape/fields as the favourites brief cards, for a home-screen list.
     */
    public function latestCompleted(int $limit = 10): array
    {
        $locale = app()->getLocale();

        return Project::where('publish_status', 0)->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(fn (Project $project) => [
                'id' => $project->id,
                'slug' => $project->slug,
                'title' => $locale === 'ar' ? $project->title_arabic : $project->title_english,
                'main_image' => $this->mediaUrl($project->main_image),
                'emirate_id' => $project->emirate_id,
            ])
            ->all();
    }

    /**
     * Full detail for one project: the publish gate + the whole relation set
     * (03_CONTENT_API.md) + absolute media URLs, ready to render as-is. Returns null
     * if not found/unpublished/deleted so the controller can 404.
     *
     * Note: only top-level project images/plans and first-level relation icons
     * (category/subcategory/style/type/partner/emirate, specification icons) get
     * absolute URLs here - floor/amenity/building-component icons nested under
     * floors/feasibilityStudies are left as raw relative paths for now.
     */
    public function detail(int $id): ?array
    {
        $project = Project::where('id', $id)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->with([
                'category', 'subcategory', 'currency', 'style', 'type', 'partner', 'emirate',
                'images',
                'floors.floorComponent', 'floors.buildingComponent',
                'floors.specifications.specification', 'floors.amenities.amenity',
                'specifications.specification',
                'constructionCosts',
                'feasibilityStudies' => fn ($q) => $q->where('status', 'Active')->whereNull('deleted_at'),
                'feasibilityStudies.currency',
                'feasibilityStudies.buildingComponents.buildingComponent',
                'feasibilityStudies.incomeComponents.incomeComponent',
                'feasibilityStudies.constructionCosts.substationRoom',
                'feasibilityStudies.constructionCosts.pumpsRoom',
                'feasibilityStudies.projectCost',
            ])
            ->first();

        if (!$project) {
            return null;
        }

        $data = $project->toArray();

        foreach (['main_image', 'cover_image', 'page_image', 'site_image', 'plan_2d_image', 'plan_3d_image'] as $field) {
            $data[$field] = $this->mediaUrl($project->{$field});
        }

        foreach (['category', 'subcategory', 'style', 'type', 'partner', 'emirate'] as $rel) {
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

        return $data;
    }

    /**
     * Available filter option lists. Categories/subcategories are narrowed to the pinned
     * scope when one is given; styles/types/emirates stay global (matches the web, which
     * never narrows those by category either). sqft/sqm ranges and each specification's
     * value list are computed from the ACTUAL matching rows - never guessed/hardcoded -
     * so a sub-filter like "6 Bathrooms" only ever offers a value that really exists.
     */
    public function filterOptions(array $constraints = []): array
    {
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;
        $pinnedSubcategoryIds = $constraints['subcategory_ids'] ?? null;

        $categories = EngineeringCategory::whereNull('deleted_at')
            ->when($pinnedCategoryIds, fn ($q) => $q->whereIn('id', $pinnedCategoryIds))
            ->whereHas('projects', fn ($q) => $q->where('publish_status', 0)->whereNull('deleted_at'))
            ->orderBy('title_english')
            ->get();

        $subcategories = EngineeringSubCategory::whereNull('deleted_at')
            ->when($pinnedSubcategoryIds, fn ($q) => $q->whereIn('id', $pinnedSubcategoryIds))
            ->when(!$pinnedSubcategoryIds && $pinnedCategoryIds, fn ($q) => $q->whereIn('category_id', $pinnedCategoryIds))
            ->whereHas('projects', fn ($q) => $q->where('publish_status', 0)->whereNull('deleted_at'))
            ->orderBy('title_english')
            ->get();

        return [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'styles' => ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get(),
            'types' => ProjectType::whereNull('deleted_at')->where('status', 0)->orderBy('name_english')->get(),
            'emirates' => Emirate::whereNull('deleted_at')->orderBy('title_english')->get(),
            'sqft_range' => $this->numericRange($this->scopedProjects($constraints), 'sqft'),
            'sqm_range' => $this->numericRange($this->scopedProjects($constraints), 'sqm'),
            'price_range' => $this->numericRange($this->scopedProjects($constraints), 'project_cost'),
            'specifications' => $this->specificationsWithValues($constraints),
        ];
    }

    /**
     * A fresh, pinned-scope-aware base query over published projects - reused by the
     * range/specification-value lookups below so they stay in sync with the same scope
     * the listing itself uses.
     */
    protected function scopedProjects(array $constraints): Builder
    {
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;
        $pinnedSubcategoryIds = $constraints['subcategory_ids'] ?? null;

        return Project::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->when($pinnedCategoryIds, fn ($q) => $q->whereIn('category_id', $pinnedCategoryIds))
            ->when($pinnedSubcategoryIds, fn ($q) => $q->whereIn('subcategory_id', $pinnedSubcategoryIds));
    }

    /**
     * MIN/MAX of $column across the given query, as-is from the DB (no sentinel
     * defaults) - null when there are no matching rows.
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
     * Each specification (e.g. "Bedrooms") + the distinct values actually used by
     * matching projects (e.g. [4, 6, 8]) - a specification with zero matching values
     * in this scope is dropped entirely rather than offered as an empty filter.
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
                $values = ProjectSpecification::where('specification_id', $spec->id)
                    ->whereNull('deleted_at')
                    ->whereHas('project', function ($q) use ($pinnedCategoryIds, $pinnedSubcategoryIds) {
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

    /**
     * whereIn the pinned ids (the boundary), then let a request value narrow further
     * ONLY if it falls inside that pinned set. A request id outside the pinned set is
     * silently ignored rather than applied - it must never let the caller escape scope.
     */
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

    /**
     * Mirrors ProjectsController::applyFilters (web). category_id/subcategory_id are
     * skipped here when a pinned scope for that dimension exists - applyPinnedConstraints
     * already handled it more strictly.
     */
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

        if ($request->filled('sqft_min') && $request->sqft_min != 50) {
            $query->where('sqft', '>=', $request->sqft_min);
        }
        if ($request->filled('sqft_max') && $request->sqft_max != 15000) {
            $query->where('sqft', '<=', $request->sqft_max);
        }

        if ($request->filled('sqm_min') && $request->sqm_min != 5) {
            $query->where('sqm', '>=', $request->sqm_min);
        }
        if ($request->filled('sqm_max') && $request->sqm_max != 1400) {
            $query->where('sqm', '<=', $request->sqm_max);
        }

        // price_min/price_max: projects price directly on the row (project_cost) -
        // unlike offers (per-emirate, via offer_prices), so this is a plain column filter.
        if ($request->filled('price_min')) {
            $query->where('project_cost', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('project_cost', '<=', $request->price_max);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_english', 'like', "%{$search}%")
                    ->orWhere('title_arabic', 'like', "%{$search}%")
                    ->orWhere('seo_tags', 'like', "%{$search}%");
            });
        }

        if ($request->filled('emirate_id')) {
            $query->where('emirate_id', $request->emirate_id);
        }

        if ($request->filled('specification_id')) {
            $specId = $request->specification_id;
            $specValue = $request->get('specification_value', '');

            $query->whereHas('specifications', function ($q) use ($specId, $specValue) {
                $q->where('specification_id', $specId);
                if (!empty($specValue)) {
                    $q->where(function ($subQ) use ($specValue) {
                        $subQ->where('value_english', 'like', "%{$specValue}%")
                            ->orWhere('value_arabic', 'like', "%{$specValue}%");
                    });
                }
            });
        }
    }

    protected function applySorting(Builder $query, Request $request): void
    {
        switch ($request->get('sortby', 'newest')) {
            case 'oldest':
                $query->orderBy('projects.created_at', 'ASC');
                break;
            case 'area_low':
                $query->orderBy('sqft', 'ASC');
                break;
            case 'area_high':
                $query->orderBy('sqft', 'DESC');
                break;
            case 'price_low':
                $query->orderBy('project_cost', 'ASC');
                break;
            case 'price_high':
                $query->orderBy('project_cost', 'DESC');
                break;
            case 'newest':
            default:
                $query->orderBy('projects.created_at', 'DESC');
                break;
        }
    }
}
