# SmartVision UAE — Project Overview

## 1. Project Description

**SmartVision UAE** is a bilingual (English / Arabic) corporate and real-estate platform built on **Laravel 10** for a UAE-based engineering, contracting, and real-estate services group.

The platform serves three audiences from a single codebase:

1. **Public visitors** — browse company services, engineering projects, real-estate offers (with pricing per emirate), portfolio work, interior-design galleries, news/blogs, team, careers, and corporate information.
2. **Authenticated admins / content editors** — manage every piece of public content, master data, SEO, menus, banners, sliders, feasibility studies, users, roles, and permissions through the `Admin` module.
3. **Sales & support staff (CRM users)** — handle leads coming from the public site: contact-us submissions, favourites/wishlists, job applications, and sales-agent assignment.

The application is organized as a **Laravel core (`app/`) + three feature modules** (`Modules/Admin`, `Modules/Basicdata`, `Modules/CRM`) using `nwidart/laravel-modules`, with full localization driven by `mcamara/laravel-localization`.

---

## 2. Tech Stack

| Layer | Stack |
|-------|-------|
| Framework | Laravel 10 (PHP 8.1+) |
| Frontend build | Vite + module-loader (per-module Vite config) |
| Templating | Blade (with locale-aware view paths) |
| Database | MySQL |
| Auth | Session auth + Laravel Sanctum (API) |
| Modules | nwidart/laravel-modules 10 |
| Localization | mcamara/laravel-localization 2.2 (en, ar) |
| PDF | barryvdh/laravel-dompdf, carlos-meneses/laravel-mpdf |
| Excel | maatwebsite/excel 3.1 |
| Image | intervention/image (GD driver) |
| Geolocation | stevebauman/location (IpApi + fallbacks) |
| Translation API | stichoza/google-translate-php |
| HTTP client | guzzlehttp/guzzle |

Module status is controlled by [modules_statuses.json](modules_statuses.json) — all three modules are currently enabled.

---

## 3. High-Level Architecture

```
smartvisionuae/
├── app/                          # Laravel core — public-facing site
│   ├── Http/Controllers/         # 21 public controllers (Home, Services, Projects, Offers, ...)
│   ├── Http/Middleware/          # 15 middleware (auth, permissions, page-view tracking, ...)
│   ├── Http/View/Composers/      # HeaderComposer — global header/footer data
│   ├── Models/                   # 116 Eloquent models (incl. Analytics/, OffersPrices/)
│   ├── Mail/                     # 5 mailables (contact + favourites flows)
│   ├── Exports/                  # FavouritesReportExport (Excel)
│   ├── Services/                 # ActivityLogService (audit log)
│   ├── Traits/                   # LogsActivity, ChecksPermissions
│   ├── Helpers/helper.php        # dataLocale, tags, menu helpers, json
│   └── Providers/                # App, Route, Permission, Auth, Broadcast, Event
├── Modules/
│   ├── Admin/                    # CMS (78 controllers, ~960-line route file)
│   ├── Basicdata/                # Master data lookups (24 controllers)
│   └── CRM/                      # Leads & sales (5 controllers)
├── routes/                       # web, api, console, channels (top-level)
├── config/                       # 21 configs incl. custom: site, modules, image,
│                                 # location, laravellocalization
├── database/migrations/          # ~174 migrations grouped by domain
├── resources/                    # views (en/ar paths), lang/, js/, css/
└── public/                       # compiled assets, themes, uploads (storage symlink)
```

### Request flow

1. `routes/web.php` wraps **public** routes in `LaravelLocalization::setLocale()` + the three locale middlewares (`localeSessionRedirect`, `localizationRedirect`, `localeViewPath`). The locale prefix becomes part of the URL (e.g., `/en/projects`, `/ar/projects`).
2. `Modules/*/routes/web.php` wraps **admin/back-office** routes with the same locale middleware **plus** `auth` and `check.route.permission` (route-level RBAC).
3. `HeaderComposer` injects shared data (header menu, footer info, project/offer categories, services, news categories, active-jobs flag) into every Blade view.
4. `LogsActivity` trait + `ActivityLogService` record every CUD action on flagged models into `activity_logs`.

---

## 4. Feature Catalogue

### 4.1 Public Site Features

| Feature | Routes | Notes |
|---|---|---|
| **Homepage** | `/` | Sliders, featured services, showcases, projects, offers, portfolios, team, FAQs, news, partners, facts |
| **Global search** | `/search`, `/search/live` | Live autocomplete + filtered results across offers/projects, with helper endpoints for emirates, categories, subcategories, types, styles |
| **Services** | `/services`, `/services/{slug}` | Main services + sub-services with features, processes, values, FAQs, image gallery, configurable section ordering |
| **Engineering Projects** | `/projects`, `/projects/featured`, `/projects/{slug}`, `/category/{slug}`, `/subcategory/{slug}`, `/engineering/{slug}` (legacy) | Filters by category/subcategory/type/style/specifications; floors with amenities & specifications; building/income/length components; construction costs; feasibility-study toggle; image gallery |
| **Real-estate Offers** | `/offers`, `/offers/category/{slug}`, `/offers/subcategory/{slug}`, `/offers/{slug}` | Multi-emirate pricing (per currency), floors, amenities, specifications, image gallery, optional feasibility study, video & virtual tour URLs |
| **Portfolios** | `/portfolios`, `/portfolios/{slug}` | Portfolio items with process steps + image gallery, grouped by portfolio types |
| **Showcases** | `/showcases`, `/showcases/{id}` | Cross-linked aggregations of services, projects, portfolios, team members, news |
| **Blog / News** | `/blogs`, `/blogs/{slug}` | News categories + posts with localized slugs (`news_slugs` table) |
| **About** | `/about` | Configurable about-page sections, features, custom blocks |
| **Team** | `/team`, `/team/board-of-directors`, `/team/{id}` | Display order + board-of-directors order; job titles & ranks |
| **Branches** | `/branches`, `/branches/{id}` | Company office locations |
| **Partners / Government clients** | `/partners`, `/partners/{id}` | Two partner types (government/private) |
| **Contact** | `/contact` (GET & POST) | Form throttled to 5/min; sends confirmation email + creates `ContactUs` record |
| **Careers** | `/careers`, `/careers/{id}`, `/careers/{id}/apply` (POST) | Active job postings with date-bounded registration window; resume upload via `JobApplication` |
| **Interior Design Gallery** | `/interior-design`, `/interior-design/category/{slug}`, `/interior-design/{slug}` | Standalone gallery with categories |
| **Favourites / Wishlist** | `/favourites/*` | Toggle, count, clear, share by token, send by email; multi-item types (projects, offers, interior items) |
| **Sitemap** | `/sitemap` (HTML), `/sitemap.xml` | XML outside locale group for clean URL |
| **Login (back-office)** | `/login`, `/checkuser`, `/logout` | Staff login; public site doesn't require auth |
| **Under-Construction mode** | `config/site.php` → `UNDER_CONSTRUCTION` env | `CheckUnderConstruction` middleware redirects public visitors; admins still see the site |

### 4.2 Admin Module (CMS)

Standard CRUD pattern across resources is `index / create / store / edit / update / destroy / show / trashed / restore` (soft deletes everywhere). Highlights:

- **Dashboard** — `/admin/` with integration-health check (`/admin/check-integrations`).
- **Analytics** — Visitors, sessions, page views, real-time, country/URL filters, journey reconstruction, data cleanup tools (`destroyByCountry`, `destroyByUrls`, `destroyOrphaned`, `destroyNullCountry`, `cleanupData`), CSV export.
- **Services** — Full lifecycle plus `togglePublish`, `toggleHomeFeature`, configurable section order, sub-controllers for features/values/processes/blocks/FAQs/galleries/titles.
- **Projects** — Lifecycle + `togglePublish`, `toggleHomeFeature`, `toggleFeasibilityStudies`, `liveSearch`, `bulkPublish`, `bulkHomeStatus`, sub-controllers for floors (with amenities & specifications), building components, income components, length components, construction costs, project specifications, image gallery.
- **Offers** — Same shape as Projects, plus `OfferPriceController` (per-emirate pricing) and `OfferFeasibilityStudyController`.
- **Feasibility Studies** — index, create-from-project, store, show, edit, update, soft-delete, force-delete, **duplicate**.
- **Portfolio** — Lifecycle + processes + image gallery.
- **Home & Pages** — HomeBlocks, Cards, HomeContact, HomeFaq, HomeSection (ordering & visibility), HomeInteriorSetting, HomeProjectSetting, PageBanner, AboutPageSection, ContactPageSection, AboutInformation/Feature/CustomBlock, DefaultBanner/Process/ProcessCard, Slider (`toggle-status`, `update-orders`), Fact.
- **Showcases** — Showcase + ShowcaseNew + relation controllers (Service, Project, Portfolio, Team, New).
- **Team** — `update-display-order`, `update-board-order`.
- **Menus** — Custom menus with hierarchical items, plus header/footer/primary fallback logic.
- **SEO** — `SeoPageController` (per-page meta), translation API (`POST /admin/translate` using Google Translate).
- **Users / Roles / Permissions** — UsersController, RoleController, UserRoleController, route-level permission gating via `CheckRoutePermission`.
- **Activity Log** — Browse audit trail with filters and old-record cleanup.
- **Site Settings** — Global toggles, contact info, site identity.
- **News & Categories** — Standard lifecycle.
- **Certificates / Partners / Sliders / Banners** — Standard lifecycle, often with ordering.

### 4.3 Basicdata Module (Master Data)

Reference lookups used across the system, all soft-deletable with `trashed` / `restore`:

- **Project domain:** ProjectType, ProjectStyle, EngineeringCategory, EngineeringSubCategory, Specification, Amenity, BuildingComponent, FloorComponent, IncomeComponent, LengthComponent, FeasibilityStudyComponent, PumpsRoom, SubstationRoom.
- **Offer domain:** OfferCategory, OfferSubCategory.
- **Other:** InteriorCategory, PortfolioType, JobCategory, JobTitle, Currency, Emirate, Rank, Language.

### 4.4 CRM Module

- **Jobs Postings** — Lifecycle of public-facing job listings (date-bounded).
- **Contact Us** — Inbox of form submissions: agent assignment / unassignment, status updates, internal notes, threaded comments, email replies (logged), delete.
- **Favourites** — Visitor wishlists with: live search, agent assignment, user-info edits, comment threads, item delete, send-email + send-notification flows, **report export to Excel** (`FavouritesReportExport`).
- **Agents** — Internal sales/support staff records (lifecycle + soft delete).

### 4.5 Cross-Cutting Capabilities

- **Localization (EN/AR)** — URL-prefixed locale, `localeViewPath` middleware, `_en` / `_ar` field convention, `dataLocale()` helper, `resources/lang/en/`, `resources/lang/ar/`.
- **RBAC** — `Role`, `Permission`, `User` pivot; `CheckPermission`, `CheckRole`, `CheckRoutePermission` middleware; `ChecksPermissions` trait; Blade directives `@permission`, `@anypermission`, `@role`, `@anyrole`; super-admin bypass.
- **Audit logging** — `LogsActivity` trait + `ActivityLogService` capture create/update/delete/restore/forceDelete/toggle/reorder/bulkCreate/auth events with diffed fields, IP, UA, and a derived record title.
- **Custom analytics** — `AnalyticsVisitor`, `AnalyticsSession`, `AnalyticsPageView`; `TrackPageView` middleware; CSRF-exempt heartbeat at `POST /analytics/heartbeat` to update `time_on_page` and `page_title`.
- **Soft deletes & trash UX** — Almost every resource exposes `trashed` listing + `restore`; some also support `force-delete`.
- **SEO** — `seo_pages` table with per-page metadata; XML + HTML sitemaps; SEO title and alt-text columns added to many content tables.
- **Email flows** — Contact confirmation, contact admin-reply, favourites direct mail, favourites notification, favourites send-by-email.

---

## 5. Development Focus Points

These are the areas where care matters most, based on how the codebase is structured. Treat this as a working checklist for any feature, fix, or refactor.

### 5.1 Localization is the default, not an afterthought
- Every user-visible string lives in `_en` / `_ar` columns or in `resources/lang/{en,ar}/`. Use `dataLocale()` or the model's locale accessor — never hard-code a language.
- Public routes are wrapped in the locale group, so `route('projects.show', $slug)` produces `/en/projects/{slug}` automatically. Do not strip or hand-build the locale prefix.
- News, projects, offers, portfolio, services, and interior items each have **localized slugs** (e.g., `news_slugs`). Always look up content by the locale-aware slug, not by ID.
- `LaravelLocalization::setLocale()` is reused by the fallback group at the end of `routes/web.php` — keep new top-level groups consistent so the 404 fallback still fires correctly.

### 5.2 Permissions are route-level
- `CheckRoutePermission` is applied to the entire admin route group. New admin routes must have a corresponding permission slug seeded via `RolesAndPermissionsSeeder`, or a super-admin flag.
- Use `ChecksPermissions::userCan()`, `canView()`, `canCreate()`, `canEdit()`, `canDelete()`, `canRestore()`, `canForceDelete()` in controllers and Blade.
- Don't bypass with raw `if (auth()->user())` — go through the trait so super-admin handling stays consistent.

### 5.3 Activity logging on every CUD path
- Models that need audit history use the `LogsActivity` trait (boots `created/updated/deleted/restored` listeners).
- For non-standard actions (toggle, reorder, bulk-create, auth, custom), call `ActivityLogService` explicitly so the event is captured.
- When adding a new model, decide up front whether it should be audited and either add the trait or document why it's excluded.

### 5.4 Soft deletes everywhere — handle the trash UI
- Almost every resource exposes `trashed` + `restore`. New resources should follow the same pattern unless there's a clear reason not to.
- Use `withTrashed()` / `onlyTrashed()` deliberately; the default scope hides soft-deleted rows, which is correct for the public site.
- `force-delete` is reserved for irreversible cleanups (e.g., feasibility studies) — gate it behind a permission and an explicit confirmation.

### 5.5 Module boundaries
- `app/Models/` is shared. Modules **consume** these models; they do not redeclare them. Keep this convention — moving a model into a module breaks other modules and the public site.
- Each module has its own `routes/web.php`, `Providers/`, and `App/Http/Controllers/`. Don't reach across modules; if two modules need the same logic, lift it into `app/Services/`.
- Module status is in [modules_statuses.json](modules_statuses.json). When disabling a module for testing, also confirm no public-site code path depends on it.

### 5.6 Validation, throttling, and request safety
- Public form endpoints must be rate-limited (`/contact` is `throttle:5,1` — replicate this on any new public POST).
- File uploads (resumes, images, gallery items) need MIME + size validation and storage on the symlinked `public` disk.
- The favourites "share by token" route is unauthenticated by design — keep tokens unguessable and short-lived if you extend it.

### 5.7 SEO discipline
- New content types should plumb into `SeoPage` (or carry `seo_title`, `meta_description`, `alt_text` columns) and into the sitemap generator (`SitemapController`).
- Slugs must be unique per locale and stable across edits — do not regenerate slugs on update without a redirect plan.
- The 404 fallback at the bottom of `routes/web.php` is the catch-all — keep it last.

### 5.8 Performance hot spots
- `HeaderComposer` runs on every request — every query added there is amplified. Cache where possible and avoid N+1.
- Public listing pages (projects, offers) eager-load floors/specifications/components — keep eager-loads narrow and paginate.
- Analytics writes happen on every page view through `TrackPageView`. Keep that path cheap and async-friendly; failures must not break page rendering.
- See [MEMORY_OPTIMIZATION_GUIDE.md](MEMORY_OPTIMIZATION_GUIDE.md) for known memory patterns.

### 5.9 Feasibility studies are a domain of their own
- Feasibility studies span 7+ tables (`feasibility_studies`, `fs_building_components`, `fs_length_components`, `fs_income_components`, `fs_construction_costs`, `fs_project_costs`, `feasibility_study_components`).
- Duplication and force-delete flows already exist — extend them rather than introducing parallel ones.
- Existing reference docs:
  - [FEASIBILITY_STUDY_DEVELOPMENT_PLAN.md](FEASIBILITY_STUDY_DEVELOPMENT_PLAN.md)
  - [FEASIBILITY_STUDY_IMPLEMENTATION_SUMMARY.md](FEASIBILITY_STUDY_IMPLEMENTATION_SUMMARY.md)
  - [FEASIBILITY_STUDY_BUGFIXES.md](FEASIBILITY_STUDY_BUGFIXES.md)
  - [FEASIBILITY_STUDY_QUICK_START_GUIDE.md](FEASIBILITY_STUDY_QUICK_START_GUIDE.md)

### 5.10 Multi-emirate pricing & currency
- Offer prices are per `Emirate` × `Currency`. Always read prices through the `OfferPrice` model — never store a single scalar price on `Offer`.
- `Currency` rows include code, symbol, and name; default to AED for UAE-facing flows.

### 5.11 Frontend & assets
- Vite is configured per module + at the root (`vite.config.js`, `Modules/*/vite.config.js`, `vite-module-loader.js`). When adding JS/CSS for a module, add it inside that module's `resources/` and register through its Vite config — don't dump it into the root.
- `public/storage` is a symlink to `storage/app/public`. After cloning or on a fresh deploy, run `php artisan storage:link`.

### 5.12 Environment & secrets
- `.env.example` is the source of truth for required env vars. New integrations (Pusher, AWS, mail, location-API keys) must be added there with safe defaults.
- `UNDER_CONSTRUCTION=true` flips the public site to the construction page while leaving admin reachable — useful for staged deploys.
- Database connection assumes MySQL; analytics-cleanup commands assume the same.

### 5.13 Console commands & maintenance
- `feasibility:clear` — wipe feasibility data (`--force`, `--all`).
- Favourites and analytics cleanup commands exist; schedule them via `app/Console/Kernel.php` if they aren't already on cron.

### 5.14 Testing reality
- The test suite is currently minimal (`tests/Feature/`, `tests/Unit/` mostly empty). Any non-trivial change to feasibility studies, offer pricing, RBAC, or analytics deserves at least one feature test before shipping.

---

## 6. Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
# configure DB credentials in .env
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
php artisan serve
```

To enable / disable a module without editing code, edit [modules_statuses.json](modules_statuses.json).

---

## 7. Related Documentation

- [README.md](README.md) — Laravel boilerplate readme
- [MEMORY_OPTIMIZATION_GUIDE.md](MEMORY_OPTIMIZATION_GUIDE.md) — memory tuning notes
- [FEASIBILITY_STUDY_QUICK_START_GUIDE.md](FEASIBILITY_STUDY_QUICK_START_GUIDE.md) — feasibility module entry point
- [FEASIBILITY_STUDY_DEVELOPMENT_PLAN.md](FEASIBILITY_STUDY_DEVELOPMENT_PLAN.md)
- [FEASIBILITY_STUDY_IMPLEMENTATION_SUMMARY.md](FEASIBILITY_STUDY_IMPLEMENTATION_SUMMARY.md)
- [FEASIBILITY_STUDY_BUGFIXES.md](FEASIBILITY_STUDY_BUGFIXES.md)
