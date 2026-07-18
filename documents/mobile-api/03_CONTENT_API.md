# Content API - Projects, Offers, Interior Design

> All PUBLIC (no token). Every query MUST apply the publish gate
> (`where('publish_status', 0)->whereNull('deleted_at')`) and return absolute image URLs
> (`url('/storage' . $path)`). Resolve `*_english` / `*_arabic` by request locale (see
> [00_OVERVIEW_AND_CONVENTIONS.md](00_OVERVIEW_AND_CONVENTIONS.md)).
>
> For each resource: copy the query, filters, sorting, and eager-loads from the referenced
> web controller method - do not reinvent them.

---

## 0. Pagination & ordering (applies to all three list endpoints)

### Pagination

The web uses Laravel `paginate()`. Match its page size per resource so the app and web behave
the same:

| Resource | Web page size | Web method |
|----------|---------------|------------|
| Projects | `paginate(9)` | [ProjectsController::index](app/Http/Controllers/ProjectsController.php) |
| Offers | `paginate(9)->withQueryString()` | [OffersController::index](app/Http/Controllers/OffersController.php) |
| Interior | `paginate(12)->withQueryString()` | [InteriorGalleryController::index](app/Http/Controllers/InteriorGalleryController.php) |

- Accept `?page=N`. Optionally accept `?per_page=N` (clamp to a max, e.g. 50) if the app wants larger grids; otherwise keep the web defaults.
- ALWAYS return the pagination meta so the app can build infinite scroll / "load more":

```json
{
  "success": true,
  "data": [ /* items */ ],
  "meta": { "current_page": 1, "per_page": 9, "total": 42, "last_page": 5, "from": 1, "to": 9 },
  "links": { "first": "…?page=1", "last": "…?page=5", "prev": null, "next": "…?page=2" }
}
```

When wrapping a paginator in a `JsonResource` collection, Laravel adds `meta` and `links`
automatically - keep that shape.

### Ordering (`sortby`) - IMPORTANT: only interior has a manual `ordering` column

There is NO admin drag-and-drop `ordering` column on `projects` or `offers`; they order by
`created_at` (and `sqft`/price). Only `interior_design_galleries` has an `ordering` column, and
its default sort honors it.

| Resource | `sortby` values (default first) | Underlying column |
|----------|--------------------------------|-------------------|
| Projects | `newest`, `oldest`, `area_low`, `area_high` | `projects.created_at`, `sqft` |
| Offers | `newest`, `oldest`, `price_low`, `price_high`, `area_low`, `area_high` | `offers.created_at`, MIN/MAX `offer_prices.price`, `sqft` |
| Interior | `newest`, `oldest`, `title_asc`, `title_desc` | default `ordering ASC, created_at DESC`; else `created_at` / `title_english` |

Notes:
- Projects/offers "default" = `newest` = `created_at DESC` (there is no curated manual order to expose).
- Interior "default" (`newest`) is actually `ordering ASC, created_at DESC` - so the admin-curated order comes first, then newest. Preserve exactly that when copying [InteriorGalleryController::index](app/Http/Controllers/InteriorGalleryController.php).
- Offers `price_low`/`price_high` use a correlated subquery over active `offer_prices` (`status = 0`) - copy the `orderByRaw` verbatim.

---

## 1. PROJECTS

Source of truth: [ProjectsController.php](app/Http/Controllers/ProjectsController.php).

### GET `/api/v1/projects`

Copy [`ProjectsController::index`](app/Http/Controllers/ProjectsController.php): base query + `applyFilters()` + `applySorting()` + `paginate(9)`. For a "featured only" mode add `?featured=1` and append `->where('home_status', 0)` (that's what `featured()` does).

Base query to replicate:

```php
Project::where('publish_status', 0)->whereNull('deleted_at')
    ->with(['category', 'subcategory', 'style', 'specifications.specification'])
    ->withCount('images');
```

Query params (all optional, from `applyFilters`/`applySorting`):

| Param | Effect |
|-------|--------|
| `category_id` | `where category_id` |
| `subcategory_id` | `where subcategory_id` |
| `style_id` | `where style_id` |
| `type_id` | `where type_id` |
| `emirate_id` | `where emirate_id` |
| `sqft_min` / `sqft_max` | range on `sqft` (web ignores sentinel defaults 50 / 15000) |
| `sqm_min` / `sqm_max` | range on `sqm` (sentinels 5 / 1400) |
| `keyword` | LIKE on `title_english`, `title_arabic`, `seo_tags` |
| `specification_id` (+ `specification_value`) | `whereHas('specifications', ...)` |
| `sortby` | `newest` (default), `oldest`, `area_low`, `area_high` |
| `page` | pagination |

Example response (list item; build in a `ProjectResource`):

```json
{
  "success": true,
  "data": [
    {
      "id": 12,
      "slug": "green-tower",
      "title": "Green Tower",
      "category": "Residential",
      "subcategory": "Apartments",
      "style": "Modern",
      "sqft": 12000,
      "sqm": 1115,
      "main_image": "https://smartvisionuae.com/storage/uploads/projects/main/green.webp",
      "total_images": 8,
      "video_count": 1
    }
  ],
  "meta": { "current_page": 1, "per_page": 9, "total": 42, "last_page": 5 }
}
```

Notes: `total_images = images_count + 1` (main image); `video_count` counts non-empty `video_url` + `tour_url` (both computed in the web `->through()` closure - replicate).

### GET `/api/v1/projects/{slug}`

Copy [`ProjectsController::show`](app/Http/Controllers/ProjectsController.php) - `firstOrFail()` by slug + publish gate + its full eager-load set:

```php
['category','subcategory','currency','style','type','partner','emirate','images',
 'floors.floorComponent','floors.buildingComponent','floors.specifications.specification',
 'floors.amenities.amenity','specifications.specification','constructionCosts',
 'feasibilityStudies'(Active only),'feasibilityStudies.currency', ...]
```

Return the resolved fields the app needs. Suggested detail shape:

```json
{
  "success": true,
  "data": {
    "id": 12, "slug": "green-tower", "title": "Green Tower",
    "description": "…", "bio": "…", "location": "Dubai Marina",
    "sqft": 12000, "sqm": 1115, "project_cost": 5000000,
    "currency": "AED",
    "category": { "id": 1, "name": "Residential" },
    "subcategory": { "id": 3, "name": "Apartments" },
    "style": { "id": 2, "name": "Modern" },
    "type": { "id": 1, "name": "Tower" },
    "emirate": { "id": 1, "name": "Dubai" },
    "main_image": "https://…/storage/uploads/projects/main/green.webp",
    "cover_image": "https://…", "plan_2d_image": "https://…/plan.pdf", "plan_3d_image": "https://…",
    "video_url": "https://youtu.be/…", "tour_url": "https://…",
    "images": [ { "id": 1, "url": "https://…", "alt": "…" } ],
    "specifications": [ { "name": "Bedrooms", "value": "3", "icon": "https://…" } ],
    "floors": [ … ]
  }
}
```

Decide with the app which heavy relations (floors, feasibility studies, construction costs) the app truly renders; omit the rest from the mobile resource to keep payloads small. 404 if not found/unpublished.

---

## 2. OFFERS

Source of truth: [OffersController.php](app/Http/Controllers/OffersController.php). Offers add PER-EMIRATE pricing.

### GET `/api/v1/offers`

Copy [`OffersController::index`](app/Http/Controllers/OffersController.php): base query + `applyFilters()` + `applySorting()` + `paginate(9)` + `processOffers()`.

Base query:

```php
Offer::where('publish_status', 0)->whereNull('deleted_at')
    ->with(['category','subcategory','style','type','currency','specifications.specification',
        'prices' => fn($q) => $q->where('status', 0), 'prices.emirate'])
    ->withCount('images');
```

Query params: same as projects PLUS pricing:

| Param | Effect |
|-------|--------|
| `category_id`, `subcategory_id`, `style_id`, `type_id` | direct `where` |
| `emirate_id` | `whereHas('prices', emirate_id + status=0)` - offer must be priced in that emirate |
| `sqft_min/max`, `sqm_min/max` | ranges (no sentinel skip for offers) |
| `price_min` / `price_max` | `whereHas('prices', status=0 [+ emirate_id if given] + price range)` |
| `keyword` | LIKE `title_english`, `title_arabic`, `seo_tags` |
| `sortby` | `newest`, `oldest`, `price_low`, `price_high` (MIN/MAX subquery on `offer_prices`), `area_low`, `area_high` |

Pricing display (replicate `processOffers()`): pick the price by selected `emirate_id` -> else primary emirate (`Emirate::getPrimary()`) -> else first available active price. Expose it as `default_price`.

Example list item:

```json
{
  "id": 7, "slug": "villa-package", "title": "Villa Package",
  "category": "Villas", "sqft": 4000,
  "main_image": "https://…/storage/uploads/offers/main/villa.webp",
  "total_images": 5, "video_count": 0,
  "currency": "AED",
  "default_price": { "emirate_id": 1, "emirate": "Dubai", "price": 250000, "notes": "…" }
}
```

### GET `/api/v1/offers/{slug}`

Copy [`OffersController::show`](app/Http/Controllers/OffersController.php). Return ALL active prices so the app can render an emirate price selector (the web builds `all_prices`, `selected_price`, `default_price`):

```json
{
  "success": true,
  "data": {
    "id": 7, "slug": "villa-package", "title": "Villa Package",
    "description": "…", "sqft": 4000, "currency": "AED",
    "category": { "id": 2, "name": "Villas" },
    "images": [ { "id": 1, "url": "https://…" } ],
    "specifications": [ { "name": "Rooms", "value": "5", "icon": "https://…" } ],
    "prices": [
      { "emirate_id": 1, "emirate": "Dubai", "price": 250000, "notes": "…" },
      { "emirate_id": 2, "emirate": "Abu Dhabi", "price": 265000, "notes": "…" }
    ],
    "default_emirate_id": 1
  }
}
```

Accept `?emirate_id=` to set `selected_price`. `default_emirate_id` = `Emirate::getPrimary()`.

---

## 3. INTERIOR DESIGN

Source of truth: [InteriorGalleryController.php](app/Http/Controllers/InteriorGalleryController.php). Model: [InteriorDesignGallery.php](app/Models/InteriorDesignGallery.php). Single `image` column (no gallery child table).

### GET `/api/v1/interior`

Copy [`InteriorGalleryController::index`](app/Http/Controllers/InteriorGalleryController.php): base query + filters + `paginate(12)`.

```php
InteriorDesignGallery::where('publish_status', 0)->whereNull('deleted_at')
    ->with(['category','projectStyle','projectType','emirate','project']);
```

Query params:

| Param | Effect |
|-------|--------|
| `category_id` | `where category_id` |
| `style_id` | `where project_style_id` (note the column name) |
| `emirate_id` | `where emirate_id` |
| `keyword` | LIKE `title_english`, `title_arabic`, `bio_english`, `bio_arabic` |
| `sortby` | `newest` (`ordering ASC, created_at DESC`), `oldest`, `title_asc`, `title_desc` |

List item:

```json
{
  "id": 4, "slug": "modern-living", "title": "Modern Living Room",
  "bio": "…", "category": "Living Rooms", "style": "Modern",
  "image": "https://…/storage/interior_design_galleries/modern.webp"
}
```

### GET `/api/v1/interior/{slug}`  (the API SHOULD add real detail)

The web [`show()`](app/Http/Controllers/InteriorGalleryController.php) 404s because `pages/interior/show.blade.php` was never built (web uses a modal on the listing). For the app, BUILD a real JSON detail endpoint using the same query the web `show()` already contains (drop the `view()->exists` guard):

```php
$gallery = InteriorDesignGallery::where('slug', $slug)
    ->where('publish_status', 0)->whereNull('deleted_at')
    ->with(['category','projectStyle','projectType','emirate','project'])->firstOrFail();
// + related: same category OR project_style_id, limit 6
```

Response:

```json
{
  "success": true,
  "data": {
    "id": 4, "slug": "modern-living", "title": "Modern Living Room",
    "bio": "…", "image": "https://…",
    "category": { "id": 1, "name": "Living Rooms" },
    "style": { "id": 2, "name": "Modern" },
    "type": { "id": 1, "name": "Residential" },
    "emirate": { "id": 1, "name": "Dubai" },
    "project": { "id": 12, "slug": "green-tower", "title": "Green Tower" },
    "related": [ { "id": 9, "slug": "…", "title": "…", "image": "https://…" } ]
  }
}
```

This is the one content endpoint that ADDS capability the web lacks - call it out to the app team (also listed in [08_GAPS_AND_BACKEND_CHANGES.md](08_GAPS_AND_BACKEND_CHANGES.md)).

---

## 4. Shared build notes

- Wrap outputs in `JsonResource` classes (`ProjectResource`, `OfferResource`, `InteriorResource`) with a shared `imageUrl()` helper.
- Keep list resources LEAN (card fields only); put heavy relations only in detail resources.
- Reuse `Emirate::getPrimary()` for offer default pricing.
- Taxonomy/filter option lists (categories, types, styles, emirates, spec values) are documented separately in [04_TAXONOMY_AND_SEARCH_API.md](04_TAXONOMY_AND_SEARCH_API.md).
