<?php

namespace App\Services\Api;

use App\Models\News;
use App\Models\Newscategory;
use App\Services\Api\Concerns\ResolvesMediaUrls;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Shared news/blog listing logic for the mobile API, mirrored from the web's
 * BlogController. Two differences from Project/Offer/InteriorQueryService: `news`
 * has no publish_status/deleted_at column at all (every row is live), and its
 * category link is `category_code` (not `category_id`) - the `category_id` filter
 * param name is kept for consistency with the rest of the API even though it maps
 * to that differently-named column.
 */
class NewsQueryService
{
    use ResolvesMediaUrls;

    public function query(Request $request): Builder
    {
        $query = News::with('category')->orderBy('created_at', 'desc');

        $this->applyFilters($query, $request);

        return $query;
    }

    public function paginate(Request $request): LengthAwarePaginator
    {
        $perPage = (int) ($request->page_size ?? 20);
        $page = (int) ($request->page ?? 1);

        return $this->query($request)->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Full detail for one news/blog item + absolute media URLs. Returns null if not
     * found so the controller can 404.
     */
    public function detail(int $id): ?array
    {
        $news = News::where('id', $id)->with('category')->first();

        if (!$news) {
            return null;
        }

        $data = $news->toArray();

        foreach (['image', 'page_image', 'cover'] as $field) {
            if (!empty($data[$field])) {
                $data[$field] = $this->mediaUrl($data[$field]);
            }
        }

        return $data;
    }

    /**
     * Categories that actually have at least one news item - same
     * "having blog_count > 0" rule as the web's BlogController.
     */
    public function filterOptions(): array
    {
        return [
            'categories' => Newscategory::whereNull('deleted_at')
                ->whereHas('news')
                ->orderBy('name_english')
                ->get(),
        ];
    }

    protected function applyFilters(Builder $query, Request $request): void
    {
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_english', 'like', "%{$search}%")
                    ->orWhere('title_arabic', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_code', $request->category_id);
        }
    }
}
