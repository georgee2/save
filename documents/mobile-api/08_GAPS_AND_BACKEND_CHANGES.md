# Gaps & Required Backend Changes

> The short, prioritized list of backend work needed BEFORE the mobile API is complete.
> Documentation only - nothing here is implemented yet. Each item: what, why, and the files
> involved. Ordered by priority.

Legend: P1 = blocks core app features · P2 = needed for parity/quality · P3 = nice-to-have.

---

## P1-1 · API locale resolution middleware

- What: a tiny middleware that reads `Accept-Language: en|ar` (fallback `?lang=`) and calls `app()->setLocale()` for `/api` requests. Default `en`.
- Why: `/api` routes have NO locale prefix or middleware today (the web localizes by URL). Every content/menu response resolves `*_english`/`*_arabic` and `getUrl()`/`getTitle()` off `app()->getLocale()`, so without this the API always returns English.
- Files: new `app/Http/Middleware/SetApiLocale.php`; register in the `api` group in [app/Http/Kernel.php](app/Http/Kernel.php).
- Effort: small.

## P1-2 · Content list & detail endpoints (Projects, Offers, Interior)

- What: build `GET /api/v1/{projects,offers,interior}` + `/{slug}` detail, reusing the exact queries/filters/sorting/eager-loads from the web controllers ([03_CONTENT_API.md](03_CONTENT_API.md)).
- Why: these are the app's primary browse features; none exist as JSON yet.
- Files: new `App\Http\Controllers\Api\V1\{Project,Offer,Interior}Controller`, `JsonResource` classes; reuse [ProjectsController](app/Http/Controllers/ProjectsController.php), [OffersController](app/Http/Controllers/OffersController.php), [InteriorGalleryController](app/Http/Controllers/InteriorGalleryController.php).
- Effort: medium. Recommend extracting the shared query/filter logic into a service or query class so web + API stay in sync.

## P1-3 · Expose interior design DETAIL

- What: a real JSON detail endpoint for interior galleries.
- Why: the web [`InteriorGalleryController::show`](app/Http/Controllers/InteriorGalleryController.php) 404s (no `pages/interior/show.blade.php`; web uses a modal). The app needs a detail screen. The query already exists in `show()` - drop the `view()->exists` guard and return JSON.
- Files: `Api\V1\InteriorController@show`.
- Effort: small.

## P1-4 · Favourites keyed by `user_id`

- What: add a nullable `user_id` (FK) + index to `favourites`, a `forUser()` scope on [Favourite.php](app/Models/Favourite.php), and token-gated favourites endpoints.
- Why: web favourites are keyed by a cookie/session id ([FavouriteController](app/Http/Controllers/FavouriteController.php)); a Sanctum token has no session, and app favourites must sync across devices/re-login.
- Files: new migration `..._add_user_id_to_favourites_table.php` (nullable `user_id`, unique `(user_id, item_type, item_id)`); [Favourite.php](app/Models/Favourite.php); new `Api\V1\FavouriteController`.
- Notes: keep `session_id` nullable for backward compat. For app favourites set `is_permanent=true` / null `expires_at` (web sets 30-day expiry). See [05_FAVOURITES_API.md](05_FAVOURITES_API.md).
- Effort: small-medium.

## P1-5 · Auth parity endpoints (forgot / reset / resend-activation)

- What: build `POST /api/v1/auth/{forgot-password,reset-password,resend-activation}` reusing the web brokers/controllers.
- Why: the app can register/login/change-password today, but cannot recover a password or re-request activation without leaving the app.
- Files: new `Api\V1\PasswordController` reusing [CustomerForgotPasswordController](app/Http/Controllers/Auth/CustomerForgotPasswordController.php), [CustomerPasswordController](app/Http/Controllers/Auth/CustomerPasswordController.php), and `CustomerRegistrationService::sendInvite()`. See [02_AUTH_AND_ACCOUNT_API.md](02_AUTH_AND_ACCOUNT_API.md).
- Effort: small-medium.

---

## P2-1 · `contact_us` project/offer/user linkage

- What: add nullable `project_id`, `offer_id`, `user_id`, `source` columns to `contact_us` (+ optional `project()`/`offer()`/`user()` relations on [ContactUs.php](app/Models/ContactUs.php)); build `POST /api/v1/inquiries`.
- Why: `contact_us` currently has no way to record which listing an inquiry is about or which customer sent it. Needed for "Enquire about this project/offer" and CRM linkage. See [06_INQUIRIES_API.md](06_INQUIRIES_API.md).
- Files: new migration; [ContactUs.php](app/Models/ContactUs.php); new `Api\V1\InquiryController` reusing [ContactController::store](app/Http/Controllers/ContactController.php) anti-spam/persistence; surface the new fields in CRM (`Modules/CRM/App/Http/Controllers/ContactUsController.php`).
- Effort: medium.

## P2-2 · Menu, site, contact & about endpoints with URL resolution

- What: build `GET /api/v1/menu`, `GET /api/v1/site` (contact + social + logo + about + category trees) and optionally `GET /api/v1/about`, running `getUrl()`/`getTitle()`/`getDynamicChildren()` and emitting absolute URLs + resolved data.
- Why: menu URLs are computed at render time, not stored; the app can't build them from raw columns. Contact/about are DB singletons the app's footer/about screens need. See [07_MENU_HEADER_SITE_API.md](07_MENU_HEADER_SITE_API.md).
- Files: new `Api\V1\NavigationController` (or `SiteController`) reusing [Menu](app/Models/Menu.php)/[MenuItem](app/Models/MenuItem.php)/[HeaderComposer](app/Http/View/Composers/HeaderComposer.php)/[ContactInformation](app/Models/ContactInformation.php)/[AboutInformation](app/Models/AboutInformation.php); `MenuResource`.
- Notes: use the REAL `contact_information` columns (`mobile`, not `phone`; `twitter`/`pinterest`; logo is static `/pic/logos/*`). Resolve all `*_english`/`*_arabic` per locale and image/PDF paths to absolute `/storage` URLs.
- Effort: medium (recursive resolution + honoring `is_visible_mobile`/`requires_auth`).

## P2-3 · Absolute image URLs everywhere (JsonResource layer)

- What: a shared helper/trait that converts stored relative image paths to `url('/storage'.$path)` and is used by every resource.
- Why: DB stores relative paths; the app can't resolve them. `GlobalSearchController` already does this inline - standardize it so no endpoint leaks a relative path. See [00_OVERVIEW_AND_CONVENTIONS.md](00_OVERVIEW_AND_CONVENTIONS.md).
- Files: `app/Http/Resources/Concerns/ResolvesMediaUrls.php` (or similar), used by all resources.
- Effort: small.

## P2-4 · Versioning + consistent envelope

- What: introduce `/api/v1` prefix + `Api\V1` namespace and a consistent success/error/pagination envelope (optionally alias existing `/api/customer/*` under v1).
- Why: keeps the contract stable and the existing endpoints untouched while new ones land under a clean version. See [00_OVERVIEW_AND_CONVENTIONS.md](00_OVERVIEW_AND_CONVENTIONS.md).
- Files: [routes/api.php](routes/api.php); base resource/response helpers.
- Effort: small.

---

## P3-1 · In-app email-change confirmation

- What: an app-friendly way to confirm an email change (deep link or an API confirm endpoint) instead of the web-only signed route `account.email.verify`.
- Why: `PUT /api/customer/profile` sets `pending_email` and emails a WEB signed link ([CustomerProfileController::update](app/Http/Controllers/Api/CustomerProfileController.php)); the app has no native confirmation screen.
- Files: reuse the existing signed route or add `Api\V1` confirm endpoint; app deep-link handling.
- Effort: small-medium.

## P3-2 · Interior design in live search

- What: add an `interior` branch to [`GlobalSearchController::liveSearch`](app/Http/Controllers/GlobalSearchController.php) and add `slug` to result rows.
- Why: live search currently covers only offers + projects and returns web `url` (not slug); the app navigates by `type` + `slug`. See [04_TAXONOMY_AND_SEARCH_API.md](04_TAXONOMY_AND_SEARCH_API.md).
- Files: [GlobalSearchController.php](app/Http/Controllers/GlobalSearchController.php).
- Effort: small.

## P3-3 · Favourites share-by-email over API (optional)

- What: expose [`FavouriteController::sendEmail`](app/Http/Controllers/FavouriteController.php) behind the token if the app wants list sharing.
- Why: non-core; web has it, app may not need it for MVP. See [05_FAVOURITES_API.md](05_FAVOURITES_API.md).
- Effort: small.

---

## Build order (recommended)

1. P1-1 locale middleware, P2-4 versioning/envelope, P2-3 media-URL trait (foundations).
2. P1-2 + P1-3 content endpoints (the app's core).
3. P2-2 menu/site (navigation shell).
4. P1-5 auth parity, P1-4 favourites.
5. P2-1 inquiries.
6. P3 items as needed.

Everything reuses existing, tested web logic - the API layer is thin controllers + resources
over the same queries. Keep the web and API sharing one query source (service/query class) so
the publish gate and filters never drift.
