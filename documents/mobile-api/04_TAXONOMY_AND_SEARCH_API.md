# Taxonomy & Search API

> These endpoints feed the app's filter UI (dropdowns/chips) and the search box. Almost all
> of this ALREADY EXISTS as JSON in [GlobalSearchController.php](app/Http/Controllers/GlobalSearchController.php)
> - it was built for the website's AJAX filter/search and already returns absolute image
> URLs and locale-resolved names. The app can reuse it directly (optionally re-expose under
> `/api/v1/*` for a clean namespace). All PUBLIC (no token).

Existing web routes (see [routes/web.php](routes/web.php)): `search.live`, `search`, and the
`getEmirates` / `getCategories` / `getSubcategories` / `getTypes` / `getStyles` lookups.

---

## 1. Filter lookups (reuse GlobalSearchController as-is)

Each returns `{ "success": true, "<key>": [ { "id", "name", "icon" } ] }` with `name`
already resolved to the current locale and `icon` as an absolute `/storage` URL.

### GET `/api/v1/taxonomies/categories?type=projects|offers`
Source: [`GlobalSearchController::getCategories`](app/Http/Controllers/GlobalSearchController.php). `type=projects` -> `EngineeringCategory`; else `OfferCategory`.

```json
{ "success": true, "categories": [ { "id": 1, "name": "Residential", "icon": "https://…/storage/…" } ] }
```

### GET `/api/v1/taxonomies/subcategories?type=projects|offers&category_id=1`
Source: [`getSubcategories`](app/Http/Controllers/GlobalSearchController.php). Returns `[]` if `category_id` missing. `EngineeringSubCategory` / `OfferSubCategory` filtered by `category_id`.

### GET `/api/v1/taxonomies/types`
Source: [`getTypes`](app/Http/Controllers/GlobalSearchController.php). `ProjectType` (uses `name_english`/`name_arabic`). Response key `types`.

### GET `/api/v1/taxonomies/styles`
Source: [`getStyles`](app/Http/Controllers/GlobalSearchController.php). `ProjectStyle`. Response key `styles`.

### GET `/api/v1/taxonomies/emirates`
Source: [`getEmirates`](app/Http/Controllers/GlobalSearchController.php). `Emirate`. Response key `emirates`.

> NOTE: these lookups return the FULL taxonomy list. The content listing pages instead show
> only taxonomies that HAVE published content (see `ProjectsController::getFilterData()` /
> `OffersController::getFilterData()` using `whereHas(...publish_status=0)` and `withCount`).
> If the app wants "only categories with results", build variants that copy that `whereHas` /
> `having('..._count','>',0)` logic instead of the flat lookups.

### GET `/api/v1/taxonomies/specification-values?specification_id=5`
Source: [`ProjectsController::getSpecificationValues`](app/Http/Controllers/ProjectsController.php). Returns distinct localized values from `project_specifications` joined to published projects:

```json
{ "values": ["3", "4", "5"] }
```

Use this to populate the second-level input after a spec is chosen (pairs with the
`specification_id` + `specification_value` project filter in [03_CONTENT_API.md](03_CONTENT_API.md)).

---

## 2. Live search

### GET `/api/v1/search?q=&type=all|offers|projects&emirate_id=&limit=5`
Source: [`GlobalSearchController::liveSearch`](app/Http/Controllers/GlobalSearchController.php). Already app-ready.

Behavior:
- Requires `q` length ≥ 2 (else returns empty results).
- Searches offers by `title_english/arabic`, `offer_code`, `offer_number`, `seo_tags`; projects by `title_english/arabic`, `project_code`, `project_number`, `seo_tags`, `location_english/arabic`.
- Optional `emirate_id` filters offers via prices and projects via `emirate_id`.
- Publish gate applied; results sorted so prefix matches rank first; capped at `limit*2`.

Response (note: `url` is a WEB route today - see below):

```json
{
  "success": true,
  "query": "villa",
  "total": 3,
  "results": [
    {
      "id": 7, "type": "offer", "type_label": "Offer",
      "title": "Villa Package", "code": "OF-100",
      "image": "https://…/storage/uploads/offers/main/villa.webp",
      "category": "Villas", "sqft": "4,000",
      "url": "https://smartvisionuae.com/en/offers/villa-package"
    },
    {
      "id": 12, "type": "project", "type_label": "Project",
      "title": "Villa Heights", "code": "PR-55",
      "image": "https://…", "category": "Residential",
      "location": "Dubai", "sqft": "12,000",
      "url": "https://…/en/projects/villa-heights"
    }
  ]
}
```

App adaptation: each result already includes `type` (`offer`/`project`), `id`, and `title`;
the app should navigate using `type` + `slug`/`id` against the content detail endpoints in
[03_CONTENT_API.md](03_CONTENT_API.md) rather than the web `url`. If a slug is needed in the
response, add `slug` to the result arrays (a one-line change in `liveSearch`). Interior design
is NOT in live search today - add an `interior` branch if the app needs it (flagged in
[08_GAPS_AND_BACKEND_CHANGES.md](08_GAPS_AND_BACKEND_CHANGES.md)).

---

## 3. Full search redirect (web-only - do NOT port as-is)

[`GlobalSearchController::search`](app/Http/Controllers/GlobalSearchController.php) just
builds a param array and `redirect()`s to the listing page. The app should NOT use it; instead
call `/api/v1/projects` or `/api/v1/offers` directly with the same query params (note the web
`search` uses `min_sqft`/`max_sqft`/`min_price`/`max_price`, while the listing filters expect
`sqft_min`/`sqft_max`/`price_min`/`price_max` - use the LISTING names documented in doc 03).
