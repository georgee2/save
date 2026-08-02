<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use App\Models\InteriorDesignGallery;
use App\Models\Offer;
use App\Models\Project;
use App\Services\Api\Concerns\ResolvesMediaUrls;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * App-only mirror of App\Http\Controllers\FavouriteController, keyed by the
 * authenticated customer's user_id instead of a session cookie (a Sanctum token has
 * no session, and favourites must sync across devices/re-login). Web favourites are
 * untouched - this is a separate identity column on the same `favourites` table
 * (see 05_FAVOURITES_API.md).
 */
class CustomerFavouriteController extends Controller
{
    use ResolvesMediaUrls;

    public function index(Request $request)
    {
        $favourites = Favourite::forUser($request->user()->id)
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();

        $grouped = $this->groupFavourites($favourites);

        return response()->json([
            'success' => true,
            'data' => $grouped,
            'meta' => [
                'total' => collect($grouped)->sum(fn ($items) => $items->count()),
            ],
        ]);
    }

    public function count(Request $request)
    {
        $items = Favourite::forUser($request->user()->id)
            ->active()
            ->select('item_type', 'item_id')
            ->get()
            ->map(fn ($f) => $f->item_type.'_'.$f->item_id)
            ->toArray();

        return response()->json([
            'count' => count($items),
            'items' => $items,
        ]);
    }

    /**
     * item_type/item_id identify WHICH item (they come from the route path, matching
     * how the client already has them - e.g. the "id" and the domain of whatever
     * project/offer/interior payload it's currently showing). emirate_id/price are
     * optional metadata about the favourite itself, not part of its identity, so they
     * stay in the body. Valid item_type values come from Favourite::itemTypes() -
     * the model's own map of type => Eloquent class - rather than a hardcoded list
     * repeated in the route/validation/response layers.
     */
    public function toggle(Request $request, string $item_type, int $item_id)
    {
        if (!\in_array($item_type, Favourite::itemTypes(), true)) {
            throw ValidationException::withMessages([
                'item_type' => ['item_type must be one of: '.implode(', ', Favourite::itemTypes()).'.'],
            ]);
        }

        $request->validate([
            'emirate_id' => 'nullable|integer',
            'price' => 'nullable|numeric',
        ]);

        $userId = $request->user()->id;
        $itemType = $item_type;
        $itemId = $item_id;

        $existing = Favourite::forUser($userId)
            ->where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            Favourite::create([
                'user_id' => $userId,
                // Column is NOT NULL for the web's session-keyed rows; app rows don't
                // use it for lookups (scoped by user_id), so a throwaway uuid satisfies
                // the constraint without touching the column's nullability.
                'session_id' => (string) Str::uuid(),
                'item_type' => $itemType,
                'item_id' => $itemId,
                'emirate_id' => $request->input('emirate_id'),
                'price' => $request->input('price'),
                // App favourites don't expire like the web's 30-day cookie-based ones.
                'is_permanent' => true,
            ]);
            $added = true;
        }

        return response()->json([
            'success' => true,
            'added' => $added,
            'count' => Favourite::countForUser($userId),
        ]);
    }

    public function remove(Request $request, $id)
    {
        $userId = $request->user()->id;

        $favourite = Favourite::forUser($userId)->findOrFail($id);
        $favourite->delete();

        return response()->json([
            'success' => true,
            'count' => Favourite::countForUser($userId),
        ]);
    }

    public function clear(Request $request)
    {
        Favourite::forUser($request->user()->id)->delete();

        return response()->json(['success' => true, 'count' => 0]);
    }

    private function groupFavourites($favourites): array
    {
        $locale = app()->getLocale();

        $projectIds = $favourites->where('item_type', 'project')->pluck('item_id');
        $offerIds = $favourites->where('item_type', 'offer')->pluck('item_id');
        $interiorIds = $favourites->where('item_type', 'interior')->pluck('item_id');

        $projects = Project::whereIn('id', $projectIds)->get()->keyBy('id');
        $offers = Offer::whereIn('id', $offerIds)
            ->with(['prices' => fn ($q) => $q->where('status', 0), 'prices.emirate'])
            ->get()->keyBy('id');
        $interiors = InteriorDesignGallery::whereIn('id', $interiorIds)->get()->keyBy('id');

        return [
            'projects' => $favourites->where('item_type', 'project')
                ->map(function ($fav) use ($projects, $locale) {
                    $project = $projects->get($fav->item_id);
                    if (!$project) {
                        return null;
                    }

                    return [
                        'favourite_id' => $fav->id,
                        'item_id' => $fav->item_id,
                        'project' => [
                            'id' => $project->id,
                            'slug' => $project->slug,
                            'title' => $locale === 'ar' ? $project->title_arabic : $project->title_english,
                            'main_image' => $this->mediaUrl($project->main_image),
                        ],
                    ];
                })->filter()->values(),

            'offers' => $favourites->where('item_type', 'offer')
                ->map(function ($fav) use ($offers, $locale) {
                    $offer = $offers->get($fav->item_id);
                    if (!$offer) {
                        return null;
                    }

                    $selectedPrice = null;
                    if ($fav->emirate_id) {
                        $price = $offer->prices->firstWhere('emirate_id', $fav->emirate_id);
                        if ($price) {
                            $selectedPrice = [
                                'emirate' => $locale === 'ar' ? $price->emirate?->title_arabic : $price->emirate?->title_english,
                                'price' => $price->price,
                            ];
                        }
                    }

                    return [
                        'favourite_id' => $fav->id,
                        'item_id' => $fav->item_id,
                        'emirate_id' => $fav->emirate_id,
                        'selected_price' => $selectedPrice,
                        'offer' => [
                            'id' => $offer->id,
                            'slug' => $offer->slug,
                            'title' => $locale === 'ar' ? $offer->title_arabic : $offer->title_english,
                            'main_image' => $this->mediaUrl($offer->main_image),
                        ],
                    ];
                })->filter()->values(),

            'interiors' => $favourites->where('item_type', 'interior')
                ->map(function ($fav) use ($interiors, $locale) {
                    $interior = $interiors->get($fav->item_id);
                    if (!$interior) {
                        return null;
                    }

                    return [
                        'favourite_id' => $fav->id,
                        'item_id' => $fav->item_id,
                        'interior' => [
                            'id' => $interior->id,
                            'slug' => $interior->slug,
                            'title' => $locale === 'ar' ? $interior->title_arabic : $interior->title_english,
                            'image' => $this->mediaUrl($interior->image),
                        ],
                    ];
                })->filter()->values(),
        ];
    }
}
