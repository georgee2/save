<?php

namespace App\Services\Api;

use App\Models\Emirate;
use App\Models\InteriorCategory;
use App\Models\InteriorDesignGallery;
use App\Models\ProjectStyle;
use App\Services\Api\Concerns\ResolvesMediaUrls;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Shared interior-gallery listing logic for the mobile API: Api\Public\InteriorController
 * and MenuItemsController::itemRoute both go through here. Interior has no subcategory
 * concept, so constraints only ever carry category_ids.
 */
class InteriorQueryService
{
    use ResolvesMediaUrls;

    /**
     * @param  array{category_ids?: array}  $constraints  Admin-pinned menu-item scope
     *         (hard boundary, same rule as Project/OfferQueryService).
     */
    public function query(Request $request, array $constraints = []): Builder
    {
        $query = InteriorDesignGallery::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->with(['category', 'projectStyle', 'projectType', 'emirate', 'project'])
            ->orderBy('created_at', 'desc');

        $this->applyPinnedConstraints($query, $request, $constraints);
        $this->applyFilters($query, $request, $constraints);

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

        return $this->query($request, $constraints)->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Full detail for one gallery item + up to 6 related items (same category or
     * style), matching the eager-load/related-items logic in the web's
     * InteriorGalleryController::show() (03_CONTENT_API.md - the web itself 404s here
     * since no detail view was ever built; the app gets a real one).
     */
    public function detail(int $id): ?array
    {
        $gallery = InteriorDesignGallery::where('id', $id)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->with(['category', 'projectStyle', 'projectType', 'emirate', 'project.images'])
            ->first();

        if (!$gallery) {
            return null;
        }

        $related = InteriorDesignGallery::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->where('id', '!=', $gallery->id)
            ->where(function ($q) use ($gallery) {
                $q->where('category_id', $gallery->category_id)
                    ->orWhere('project_style_id', $gallery->project_style_id);
            })
            ->with(['category', 'projectStyle'])
            ->limit(6)
            ->get();

        $data = $gallery->toArray();
        $data['image'] = $this->mediaUrl($gallery->image);

        foreach (['category', 'projectStyle', 'projectType', 'emirate'] as $rel) {
            if (!empty($data[$rel]['icon'])) {
                $data[$rel]['icon'] = $this->mediaUrl($data[$rel]['icon']);
            }
            if (!empty($data[$rel]['image'])) {
                $data[$rel]['image'] = $this->mediaUrl($data[$rel]['image']);
            }
        }

        // When this gallery is linked to a project, include that project's own photo
        // gallery too (project_images, via project.images) - resolved to absolute URLs.
        if (!empty($data['project']['images'])) {
            foreach ($data['project']['images'] as &$projectImage) {
                $projectImage['image'] = $this->mediaUrl($projectImage['image']);
            }
            unset($projectImage);
        }

        $data['related'] = $related->map(function (InteriorDesignGallery $item) {
            $item = $item->toArray();
            $item['image'] = $this->mediaUrl($item['image']);

            return $item;
        })->values()->toArray();

        return $data;
    }

    public function filterOptions(array $constraints = []): array
    {
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;

        $categories = InteriorCategory::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->when($pinnedCategoryIds, fn ($q) => $q->whereIn('id', $pinnedCategoryIds))
            ->get();

        return [
            'categories' => $categories,
            'styles' => ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get(),
            'emirates' => Emirate::whereNull('deleted_at')->orderBy('title_english')->get(),
        ];
    }

    protected function applyPinnedConstraints(Builder $query, Request $request, array $constraints): void
    {
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;

        if (!empty($pinnedCategoryIds)) {
            $query->whereIn('category_id', $pinnedCategoryIds);

            if ($request->filled('category_id') && in_array((string) $request->category_id, array_map('strval', $pinnedCategoryIds), true)) {
                $query->where('category_id', $request->category_id);
            }
        }
    }

    protected function applyFilters(Builder $query, Request $request, array $constraints): void
    {
        $pinnedCategoryIds = $constraints['category_ids'] ?? null;

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_english', 'like', '%'.$search.'%')
                    ->orWhere('title_arabic', 'like', '%'.$search.'%');
            });
        }

        if (empty($pinnedCategoryIds) && $request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('emirate_id')) {
            $query->where('emirate_id', $request->emirate_id);
        }

        if ($request->filled('style_id')) {
            $query->where('project_style_id', $request->style_id);
        }
    }
}
