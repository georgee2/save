<?php

namespace App\Services\Api;

use App\Services\Api\Concerns\ResolvesMediaUrls;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Unified search across projects/offers/interior/news for the mobile app's global
 * search. Each domain is queried with its own publish gate (news has none - see
 * NewsQueryService) and its own "worth matching" text columns, normalized to one
 * shared shape (id/domain/title/description/image/slug/created_at), then combined
 * with UNION ALL so pagination/total-count happen at the DB level across all four
 * tables in one query, rather than approximated by merging separate result sets
 * in PHP.
 */
class GlobalSearchQueryService
{
    use ResolvesMediaUrls;

    public function paginate(Request $request): LengthAwarePaginator
    {
        $search = trim((string) $request->search);
        $perPage = (int) ($request->page_size ?? 20);
        $page = (int) ($request->page ?? 1);

        $query = $this->projectsQuery($search);
        $query->unionAll($this->offersQuery($search));
        $query->unionAll($this->interiorQuery($search));
        $query->unionAll($this->newsQuery($search));

        $paginator = $query->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $paginator->getCollection()->transform(function ($row) {
            $row->image = $this->mediaUrl($row->image);

            return $row;
        });

        return $paginator;
    }

    protected function projectsQuery(string $search): Builder
    {
        return DB::table('projects')
            ->select([
                'id',
                DB::raw("'projects' as domain"),
                'title_english', 'title_arabic',
                'description_english', 'description_arabic',
                'main_image as image',
                'slug',
                'created_at',
            ])
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->where(fn ($q) => $this->matchText($q, $search, [
                'title_english', 'title_arabic',
                'description_english', 'description_arabic',
                'bio_english', 'bio_arabic',
            ]));
    }

    protected function offersQuery(string $search): Builder
    {
        return DB::table('offers')
            ->select([
                'id',
                DB::raw("'offers' as domain"),
                'title_english', 'title_arabic',
                'description_english', 'description_arabic',
                'main_image as image',
                'slug',
                'created_at',
            ])
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->where(fn ($q) => $this->matchText($q, $search, [
                'title_english', 'title_arabic',
                'description_english', 'description_arabic',
                'bio_english', 'bio_arabic',
            ]));
    }

    protected function interiorQuery(string $search): Builder
    {
        return DB::table('interior_design_galleries')
            ->select([
                'id',
                DB::raw("'interior' as domain"),
                'title_english', 'title_arabic',
                'bio_english as description_english', 'bio_arabic as description_arabic',
                'image',
                'slug',
                'created_at',
            ])
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->where(fn ($q) => $this->matchText($q, $search, [
                'title_english', 'title_arabic',
                'bio_english', 'bio_arabic',
            ]));
    }

    protected function newsQuery(string $search): Builder
    {
        return DB::table('news')
            ->select([
                'id',
                DB::raw("'news' as domain"),
                'title_english', 'title_arabic',
                'bio_english as description_english', 'bio_arabic as description_arabic',
                'image',
                'slug',
                'created_at',
            ])
            // No publish_status/deleted_at column exists on news (see
            // NewsQueryService) - every row is live.
            ->where(fn ($q) => $this->matchText($q, $search, [
                'title_english', 'title_arabic',
                'bio_english', 'bio_arabic',
                'body_english', 'body_arabic',
            ]));
    }

    protected function matchText(Builder $query, string $search, array $columns): Builder
    {
        foreach ($columns as $i => $column) {
            $i === 0
                ? $query->where($column, 'like', "%{$search}%")
                : $query->orWhere($column, 'like', "%{$search}%");
        }

        return $query;
    }
}
