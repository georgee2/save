# Mobile App API - Overview & Conventions

> Audience: the backend developer building the REST APIs that the SmartVision UAE (SVEC)
> mobile app will consume. This folder documents, per feature, the exact endpoints to build
> and where the equivalent logic already lives on the website so you reuse it instead of
> re-writing it.
>
> Deliverable status: this is a specification/guide. It does NOT create controllers, routes,
> or migrations. Where an endpoint is marked "TO BUILD", the guide gives the spec plus the
> exact existing code to copy the behavior from.

## Document index

| #   | File                                                             | Covers                                                                              |
| --- | ---------------------------------------------------------------- | ----------------------------------------------------------------------------------- |
| 00  | [00_OVERVIEW_AND_CONVENTIONS.md](00_OVERVIEW_AND_CONVENTIONS.md) | Conventions, auth, locale, image URLs, envelope, endpoint index (this file)         |
| 01  | [01_CODEBASE_MAP.md](01_CODEBASE_MAP.md)                         | Where every feature lives: models, tables, migrations, controllers, routes, views   |
| 02  | [02_AUTH_AND_ACCOUNT_API.md](02_AUTH_AND_ACCOUNT_API.md)         | Register, login, logout, profile, password (exist) + forgot/reset/resend (to build) |
| 03  | [03_CONTENT_API.md](03_CONTENT_API.md)                           | Projects, Offers, Interior Design: list + detail                                    |
| 04  | [04_TAXONOMY_AND_SEARCH_API.md](04_TAXONOMY_AND_SEARCH_API.md)   | Categories, subcategories, types, styles, emirates, specs, live search              |
| 05  | [05_FAVOURITES_API.md](05_FAVOURITES_API.md)                     | Favourites list/toggle/remove/clear (token-gated)                                   |
| 06  | [06_INQUIRIES_API.md](06_INQUIRIES_API.md)                       | Contact + project/offer inquiries                                                   |
| 07  | [07_MENU_HEADER_SITE_API.md](07_MENU_HEADER_SITE_API.md)         | Menu tree + site/contact/social/logo                                                |
| 08  | [08_GAPS_AND_BACKEND_CHANGES.md](08_GAPS_AND_BACKEND_CHANGES.md) | Backend changes required before the API is complete                                 |

## 1. Base URL & versioning

- Current API base: `/api` (see [routes/api.php](routes/api.php)). Auth already lives under `/api/customer/*`.
- Recommendation: put all NEW mobile endpoints under a version prefix `/api/v1` and namespace controllers `App\Http\Controllers\Api\V1`. Keep the existing `/api/customer/*` auth endpoints working (or alias them under `/api/v1/customer/*`) to avoid breaking anything already integrated.
- Use `App\Http\Resources\*` (`JsonResource`) classes to shape responses consistently instead of hand-building arrays in controllers.

## 2. Authentication model (locked decision)

- Content browse is PUBLIC (no token): projects, offers, interior design, taxonomies, menu, site info, search.
- Personalized actions REQUIRE the customer Sanctum token: favourites, inquiries tied to the user, profile, password.
- One unified account across app, website, and ERP: the app and website share the SAME `users` table and the SAME [CustomerRegistrationService](app/Services/CustomerRegistrationService.php); an account made in the app works on the website (and, when ERP is enabled, syncs to ERPNext) with no extra work by the app team. Only the `source` column differs (`app` vs `web`). Details in [02_AUTH_AND_ACCOUNT_API.md](02_AUTH_AND_ACCOUNT_API.md).
- Tokens are issued by the existing [CustomerAuthController::login](app/Http/Controllers/Api/CustomerAuthController.php) with abilities `customer:read` and `customer:write`. Send them as:

```
Authorization: Bearer <plainTextToken>
Accept: application/json
```

- Protect read endpoints with `auth:sanctum` + `ability:customer:read`; write endpoints with `ability:customer:write` (the `ability` middleware alias is registered in [app/Http/Kernel.php](app/Http/Kernel.php)).
- Only `account_type = customer` and `is_active = true` accounts may authenticate (already enforced at login).

## 3. Localization (important - API routes are NOT localized)

The website localizes via URL prefix (`/en/...`, `/ar/...`) using `mcamara/laravel-localization`. The `/api` routes have NO locale prefix and NO locale middleware today. For the app:

- The app must send the desired language via `Accept-Language: en` or `Accept-Language: ar` (recommended), with an optional `?lang=en|ar` query fallback.
- The API must resolve that into `app()->setLocale()` early in the request (a tiny middleware - see [08_GAPS_AND_BACKEND_CHANGES.md](08_GAPS_AND_BACKEND_CHANGES.md)). Default/fallback: `en`.
- Content is stored as PAIRED COLUMNS, not a translation package: `title_english` / `title_arabic`, `name_english` / `name_arabic`, `description_english` / `description_arabic`, etc. Resolve per request:

```php
$title = app()->getLocale() === 'ar' ? $model->title_arabic : $model->title_english;
```

- Recommendation: return the resolved single-language string (e.g. `title`) in list responses for simplicity, and optionally include both languages on detail responses if the app caches content across language switches.

## 4. Image URLs (must be absolute)

Image columns store RELATIVE paths with a leading slash, e.g. `/uploads/projects/main/abc.webp` or `/interior_design_galleries/x.webp`. The public disk is symlinked at `/storage`. The web builds URLs as `url('/storage' . $path)`. The API must return ABSOLUTE URLs:

```php
$url = $path ? url('/storage' . $path) : null;   // => https://smartvisionuae.com/storage/uploads/...
```

Never return the raw relative path to the app. Do this in your `JsonResource`.

## 5. The publish gate (applies to ALL content queries)

Flags are INVERTED from the typical Laravel convention:

- `publish_status = 0` means PUBLISHED (1 = hidden).
- `home_status = 0` means shown on home / featured (1 = not).
- All content models use `SoftDeletes`, so also require `deleted_at IS NULL`.

Every content query MUST include:

```php
->where('publish_status', 0)->whereNull('deleted_at')
```

## 6. Standard response envelope

Follow the shapes the existing controllers already return so the app has one contract.

Success (single / action):

```json
{ "success": true, "data": {} }
```

List with pagination (mirror Laravel's `paginate()` meta; web uses `paginate(9)` for projects/offers and `paginate(12)` for interior):

```json
{
    "success": true,
    "data": [{}],
    "meta": { "current_page": 1, "per_page": 9, "total": 42, "last_page": 5 },
    "links": { "next": "...", "prev": null }
}
```

Validation error (HTTP 422) - Laravel's default `ValidationException` shape, already produced by the existing API controllers:

```json
{
    "message": "The email field is required.",
    "errors": { "email": ["The email field is required."] }
}
```

Rate limited (HTTP 429): same shape with a "too many attempts" message (the existing auth endpoints throw a 429 `ValidationException`).

## 7. Rate limiting

Reuse the existing pattern (see [CustomerAuthController.php](app/Http/Controllers/Api/CustomerAuthController.php)): route throttle (`throttle:x,1`) plus per-email/per-user `RateLimiter` for sensitive actions (register, login, inquiries). Keep messages generic (no user enumeration).

## 8. Full endpoint index (the contract)

Legend: [E] already exists, [B] to build.

### Public (no token)

| Method | Path                                                        | Purpose                                                    | Status        |
| ------ | ----------------------------------------------------------- | ---------------------------------------------------------- | ------------- | --- |
| GET    | `/api/v1/projects`                                          | List/filter/sort/paginate projects                         | [B]           |
| GET    | `/api/v1/projects/{slug}`                                   | Project detail                                             | [B]           |
| GET    | `/api/v1/offers`                                            | List/filter/sort/paginate offers (with pricing)            | [B]           |
| GET    | `/api/v1/offers/{slug}`                                     | Offer detail                                               | [B]           |
| GET    | `/api/v1/interior`                                          | List/filter/paginate interior gallery                      | [B]           |
| GET    | `/api/v1/interior/{slug}`                                   | Interior detail (web has none - see doc 03)                | [B]           |
| GET    | `/api/v1/taxonomies/categories?type=projects                | offers`                                                    | Category list | [B] |
| GET    | `/api/v1/taxonomies/subcategories?type=&category_id=`       | Subcategory list                                           | [B]           |
| GET    | `/api/v1/taxonomies/types`                                  | Project types                                              | [B]           |
| GET    | `/api/v1/taxonomies/styles`                                 | Project styles                                             | [B]           |
| GET    | `/api/v1/taxonomies/emirates`                               | Emirates                                                   | [B]           |
| GET    | `/api/v1/taxonomies/specification-values?specification_id=` | Distinct spec values                                       | [B]           |
| GET    | `/api/v1/search?q=&type=&emirate_id=`                       | Live search                                                | [B]           |
| GET    | `/api/v1/menu`                                              | Header + footer menu trees (resolved)                      | [B]           |
| GET    | `/api/v1/site`                                              | Contact info, social, logo, about, category trees          | [B]           |
| GET    | `/api/v1/about`                                             | Full About page content (optional; else nested in `/site`) | [B]           |

### Auth & account

| Method | Path                             | Purpose                                       | Status |
| ------ | -------------------------------- | --------------------------------------------- | ------ |
| POST   | `/api/customer/register`         | Register (invite email)                       | [E]    |
| POST   | `/api/customer/login`            | Login -> token                                | [E]    |
| POST   | `/api/customer/logout`           | Revoke current token                          | [E]    |
| GET    | `/api/customer/me`               | Basic identity                                | [E]    |
| GET    | `/api/customer/profile`          | Full profile                                  | [E]    |
| PUT    | `/api/customer/profile`          | Update details/prefs (email change -> verify) | [E]    |
| PUT    | `/api/customer/password`         | Change password                               | [E]    |
| POST   | `/api/v1/auth/forgot-password`   | Email a reset link                            | [B]    |
| POST   | `/api/v1/auth/reset-password`    | Reset via token                               | [B]    |
| POST   | `/api/v1/auth/resend-activation` | Resend set-password invite                    | [B]    |

### Token-gated (customer)

| Method | Path                        | Purpose                               | Status |
| ------ | --------------------------- | ------------------------------------- | ------ |
| GET    | `/api/v1/favourites`        | List favourites (grouped)             | [B]    |
| GET    | `/api/v1/favourites/count`  | Count + id list                       | [B]    |
| POST   | `/api/v1/favourites/toggle` | Add/remove a favourite                | [B]    |
| DELETE | `/api/v1/favourites/{id}`   | Remove one                            | [B]    |
| DELETE | `/api/v1/favourites`        | Clear all                             | [B]    |
| POST   | `/api/v1/inquiries`         | Inquiry (optional project/offer link) | [B]    |
| POST   | `/api/v1/contact`           | General contact message               | [B]    |

See each domain doc for request fields, response JSON, and the exact source logic to reuse.
