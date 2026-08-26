<?php

namespace App\Services\Api;

use App\Models\Service;
use App\Services\Api\Concerns\ResolvesMediaUrls;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Shared service listing logic for the mobile API. Services have no category
 * system - they're a parent/sub-service hierarchy instead (`is_sub_service` +
 * `service_id` self-FK) - so listings only ever show top-level (main) services,
 * same as the web's Service::getservices()/serviceshome(). Unpinned, like News:
 * there's no admin category-scoping mechanism to pin a menu item to.
 */
class ServiceQueryService
{
    use ResolvesMediaUrls;

    public function query(Request $request): Builder
    {
        $query = Service::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->where('is_sub_service', 0)
            ->orderBy('created_at', 'desc');

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
     * Full detail for one service + its published sub-services + absolute media
     * URLs. Returns null if not found/unpublished/deleted so the controller can 404.
     */
    public function detail(int $id): ?array
    {
        $service = Service::where('id', $id)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->with('subServices')
            ->first();

        if (!$service) {
            return null;
        }

        $data = $service->toArray();

        foreach (['main_image', 'service_home_image', 'icon', 'hero_image'] as $field) {
            $data[$field] = $this->mediaUrl($data[$field] ?? null);
        }

        if (!empty($data['sub_services'])) {
            foreach ($data['sub_services'] as &$subService) {
                foreach (['main_image', 'service_home_image', 'icon', 'hero_image'] as $field) {
                    $subService[$field] = $this->mediaUrl($subService[$field] ?? null);
                }
            }
            unset($subService);
        }

        return $data;
    }

    /**
     * No independent filter dimension exists for services (no category table) -
     * kept for response-shape consistency with the other domains rather than
     * fabricating a meaningless filter.
     */
    public function filterOptions(): array
    {
        return [];
    }

    /**
     * Cheap existence check - used by MenuItemsController::index() to drop menu
     * items with nothing to show.
     */
    public function hasAny(): bool
    {
        return $this->query(new Request())->exists();
    }

    protected function applyFilters(Builder $query, Request $request): void
    {
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_english', 'like', "%{$search}%")
                    ->orWhere('title_arabic', 'like', "%{$search}%")
                    ->orWhere('description_english', 'like', "%{$search}%")
                    ->orWhere('description_arabic', 'like', "%{$search}%")
                    ->orWhere('bio_english', 'like', "%{$search}%")
                    ->orWhere('bio_arabic', 'like', "%{$search}%");
            });
        }
    }
}
