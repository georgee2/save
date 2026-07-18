# Menu, Header & Site API

> PUBLIC (no token). Two endpoints: `/api/v1/menu` (the resolved navigation trees) and
> `/api/v1/site` (contact info, social, logo, category trees). The web builds all of this in
> [Menu.php](app/Models/Menu.php) / [MenuItem.php](app/Models/MenuItem.php) and injects the
> global data through [HeaderComposer.php](app/Http/View/Composers/HeaderComposer.php). The
> API must resolve the same data into ABSOLUTE URLs the app can act on, because a `MenuItem`
> URL is computed at render time (not stored).

---

## 1. Why menu needs server-side resolution

`menu_items` rows are not plain links. `MenuItem::getUrl()` resolves a URL based on
`item_type` ([MenuItem.php](app/Models/MenuItem.php)):

| `item_type` | Behavior |
|-------------|----------|
| `static` | uses `route_name`(+`route_params`) or raw `url` |
| `dynamic_services` | links to `services.show` of the selected `service_id` |
| `dynamic_offers` / `dynamic_projects` / `dynamic_news` | dropdown parents whose children come from `getDynamicChildren()` |
| `dynamic_query` | direct link to a category/subcategory listing, OR a dropdown if `show_children` |
| `category_with_subs` | parent = category page, children = subcategories |
| `divider` / `header` | no URL (visual only) |

So the app cannot just read the DB columns; the API must run `getUrl()` + `getTitle()` +
`getDynamicChildren()` per item and emit a resolved, absolute-URL tree. Build a
`MenuResource` that walks the tree.

## 2. GET `/api/v1/menu`

Reuse the same accessors the web uses ([HeaderComposer::build](app/Http/View/Composers/HeaderComposer.php)):

```php
$header = Menu::getHeaderMenu();                 // primary, or last active header menu
$headerItems = $header ? $header->getHierarchicalItems() : collect();   // nested, active-only
$quick = optional(Menu::getFooterQuickLinksMenu())->getHierarchicalItems() ?? collect();
$company = optional(Menu::getFooterCompanyMenu())->getHierarchicalItems() ?? collect();
```

For each node emit (recursively): `title` (`getTitle()`), `url` (absolute - pass `getUrl()`
through `url()` if it returns a relative path), `type` (`item_type`), `target` (`link_target`),
`icon` (resolved to absolute if image), and `children`. Skip nodes hidden for the platform
(the web has `is_visible_mobile` on `menu_items` - honor it: only include items where
`is_active` AND `is_visible_mobile`). Respect `requires_auth` / `requires_guest` so the app can
hide account-only links when logged out.

Response:

```json
{
  "success": true,
  "data": {
    "header": [
      { "title": "Home", "url": "https://smartvisionuae.com/en", "type": "static", "target": "_self", "icon": null, "children": [] },
      { "title": "Projects", "url": null, "type": "dynamic_projects", "target": "_self", "icon": null,
        "children": [ { "title": "Residential", "url": "https://…/en/projects?category_id=1", "type": "dynamic_query", "children": [] } ] }
    ],
    "footer_quick_links": [ { "title": "About", "url": "https://…/en/about", "type": "static", "children": [] } ],
    "footer_company": [ … ]
  }
}
```

Notes:
- `getHierarchicalItems()` already filters to active items and nests children via `buildTree()`.
- Nodes with `url === null` (dropdown parents, dividers, headers) are group labels - the app renders them as expandable sections, not tappable links.
- Locale: resolve with the request `Accept-Language` (see [00_OVERVIEW_AND_CONVENTIONS.md](00_OVERVIEW_AND_CONVENTIONS.md)) BEFORE calling `getTitle()`/`getUrl()`, since both read `app()->getLocale()`.

## 3. GET `/api/v1/site`

Reuse the rest of [HeaderComposer::build](app/Http/View/Composers/HeaderComposer.php) +
[ContactInformation::getContactInfo()](app/Models/ContactInformation.php). This is the app's
one-shot bootstrap for footer/contact/branding and the category trees used by menus and
filters.

### Contact info - use the REAL `contact_information` columns

`ContactInformation` is a SINGLETON ([getContactInfo()](app/Models/ContactInformation.php)
returns the first row, creating it if absent). The actual columns are (there is NO `phone` -
it is `mobile`; NO `working_hours`; social is a flat set of columns, not a nested object):

| Column | Meaning |
|--------|---------|
| `email` | contact email |
| `mobile` / `secondary_mobile` | phone numbers |
| `whatsapp` | whatsapp number |
| `facebook`, `instagram`, `linkedin`, `twitter`, `pinterest` | social links |
| `location_text_english` / `location_text_arabic` | address text (bilingual) |
| `location_map` | embed/map URL |
| `footer_bio_english` / `footer_bio_arabic` | footer blurb (bilingual) |
| `seo_description_english` / `seo_description_arabic` | SEO text |
| `tags` | JSON array |

> Logo is NOT in the DB. The site logo is a STATIC asset: `url('/pic/logos/logoen.png')` and
> `url('/pic/logos/logoar.png')` (see `resources/views/includes/header.blade.php`). Return the
> locale-appropriate absolute URL, or let the app bundle its own logo.

Suggested payload:

```json
{
  "success": true,
  "data": {
    "contact": {
      "email": "info@smartvisionuae.com",
      "mobile": "+9714…", "secondary_mobile": "+9714…", "whatsapp": "+9715…",
      "address": "Business Bay, Dubai, UAE",
      "location_map": "https://maps.google.com/…",
      "footer_bio": "…",
      "social": { "facebook": "…", "instagram": "…", "linkedin": "…", "twitter": "…", "pinterest": "…" }
    },
    "logo": "https://smartvisionuae.com/pic/logos/logoen.png",
    "about": {
      "title": "About SmartVision", "subtitle": "…",
      "about": "…", "about_image": "https://…/storage/…",
      "mission": "…", "vision": "…",
      "values": "…", "values_points": ["…"],
      "company_profile": "https://…/storage/…/profile.pdf"
    },
    "project_categories": [ { "id": 1, "name": "Residential", "subcategories": [ { "id": 3, "name": "Apartments" } ] } ],
    "offer_categories":   [ { "id": 2, "name": "Villas", "subcategories": [ … ] } ],
    "services":           [ { "id": 5, "name": "Interior Fit-out", "sub_services": [ … ] } ],
    "has_active_jobs": true
  }
}
```

Sources:
- `contact` -> `ContactInformation::getContactInfo()` (singleton; resolve `location_text_*` and `footer_bio_*` per locale into `address` / `footer_bio`).
- `logo` -> static `/pic/logos/logo{en|ar}.png` by locale.
- `about` -> `AboutInformation::getAboutInfo()` (see next section).
- `project_categories` -> `EngineeringCategory::with('subCategories')` (from `HeaderComposer`).
- `offer_categories` -> `OfferCategory::with('subCategories')` (from `HeaderComposer`).
- `services` -> `Service::with('subServices')` where `is_sub_service=0`, `publish_status=0`.
- `has_active_jobs` -> the `jobs_postings` existence check (drives a "Careers" nav entry).

Return every `name`/text resolved per locale from `*_english`/`*_arabic`.

### About info

The web "About" page data is a SINGLETON in [AboutInformation.php](app/Models/AboutInformation.php)
(`AboutInformation::getAboutInfo()`, table `about_information`, used by
[ContactController::index](app/Http/Controllers/ContactController.php)). Columns (all bilingual
`*_english`/`*_arabic` unless noted):

`title`, `subtitle`, `about`, `about_image` (path), `mission`, `mission_image`, `vision`,
`vision_image`, `values`, `values_points`, `values_image`, `page_cover_image` (path),
`company_profile` (PDF path).

Options:
- Include a trimmed `about` block inside `/api/v1/site` (as above) for the app's About screen, OR
- Expose a dedicated `GET /api/v1/about` returning the full record if the app has a rich About page (mission/vision/values images, cover, company-profile PDF).

Resolve all `*_english`/`*_arabic` per locale and convert every image/PDF path to an absolute
`url('/storage'.$path)` URL.

## 4. The mobile bottom navigation is NOT from the DB

The website's mobile bottom bar is a hardcoded Blade partial
(`resources/views/includes/mobile-bottom-nav.blade.php`), not driven by `menu_items`. The app
should define its own native tab bar (Home / Projects / Offers / Favourites / Account) and use
`/api/v1/menu` only for the drawer / "more" menu content. Do not try to derive tabs from the
menu tree.

## 5. Caching

`HeaderComposer` memoizes per request. For the API, these payloads change rarely - wrap
`/api/v1/menu` and `/api/v1/site` in a short cache (e.g. `Cache::remember(..., 300, ...)`,
keyed by locale) to keep app cold-starts fast. Bust on menu/contact-info admin updates if you
want immediacy.
