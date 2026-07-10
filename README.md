# SmartVision UAE (SVEC) — Corporate & Real-Estate Platform

A bilingual (English / Arabic) corporate, engineering, and real-estate platform built on **Laravel 10** for **Smart Vision Engineering Consultants (SVEC)**, a UAE-based engineering, contracting, and real-estate services group.

The platform runs a public marketing website, a full content-management back office, and a light CRM — from a single codebase organized as a Laravel core plus three feature modules.

> 📚 **Detailed documentation lives in the [`documents/`](documents/) folder.** Start with [`documents/PROJECT_OVERVIEW.md`](documents/PROJECT_OVERVIEW.md) for the deep architecture guide.

---

## Table of Contents

- [Who it serves](#who-it-serves)
- [Tech stack](#tech-stack)
- [Architecture](#architecture)
- [Feature summary](#feature-summary)
- [Requirements](#requirements)
- [Local setup](#local-setup)
- [Deployment](#deployment)
- [SEO & URL handling](#seo--url-handling)
- [Common commands](#common-commands)
- [Documentation index](#documentation-index)

---

## Who it serves

| Audience | What they do |
|---|---|
| **Public visitors** | Browse services, engineering projects, real-estate offers (priced per emirate), portfolios, interior-design galleries, news, team, careers, and corporate info — in EN or AR. |
| **Admins / content editors** | Manage all public content, master data, SEO, menus, banners, sliders, feasibility studies, users, roles, and permissions via the **Admin** module. |
| **Sales & support (CRM)** | Handle leads from the public site: contact submissions, favourites/wishlists, job applications, and agent assignment via the **CRM** module. |

---

## Tech stack

| Layer | Stack |
|-------|-------|
| Framework | Laravel 10 (PHP 8.1+) |
| Modules | `nwidart/laravel-modules` 10 |
| Localization | `mcamara/laravel-localization` 2.2 (`en`, `ar`) |
| Database | MySQL |
| Auth | Session auth + Laravel Sanctum (API) |
| Frontend | Blade (locale-aware view paths) + Vite (per-module) |
| PDF | `barryvdh/laravel-dompdf`, `carlos-meneses/laravel-mpdf` |
| Excel | `maatwebsite/excel` 3.1 |
| Images | `intervention/image` (GD, WebP output) |
| Geolocation | `stevebauman/location` (IP API + fallbacks) |
| Translation | `stichoza/google-translate-php` |

---

## Architecture

```
smartvisionuae/
├── app/                    # Laravel core — public-facing site + shared models
│   ├── Http/Controllers/   # Public controllers (Home, Services, Projects, Offers, ...)
│   ├── Http/Middleware/     # Auth, RBAC, page-view tracking, under-construction,
│   │                        #   LegacyRedirect (301s old/`/public` URLs)
│   ├── Http/View/Composers/ # HeaderComposer — global header/footer data (runs every request)
│   ├── Models/              # Shared Eloquent models (incl. Analytics/, OffersPrices/)
│   ├── Traits/              # LogsActivity, ChecksPermissions, RecordsSlugRedirects, HasUniqueSlug
│   ├── Services/            # ActivityLogService (audit log)
│   └── Providers/           # App, Route, Permission, Auth, Broadcast, Event
├── Modules/
│   ├── Admin/               # CMS — content, SEO, menus, feasibility studies, users/roles
│   ├── Basicdata/           # Master-data lookups (categories, types, styles, components…)
│   └── CRM/                 # Leads & sales — contact inbox, favourites, agents, job postings
├── routes/                  # web, api, console, channels (public + sitemap + analytics)
├── config/                  # incl. custom: site, image, location, laravellocalization,
│                            #   legacy_redirects (old-URL → listing patterns)
├── database/migrations/     # ~175 migrations grouped by domain
├── resources/               # Blade views, lang/{en,ar}, js/, css/
├── public/                  # compiled assets, uploads (storage symlink), robots.txt, sitemap
└── documents/               # project & feature documentation (see index below)
```

**Request flow:** public routes are wrapped in `LaravelLocalization::setLocale()` + locale middleware, so the locale prefix is part of every URL (`/en/projects`, `/ar/projects`). Admin/back-office routes add `auth` + `check.route.permission` (route-level RBAC). `HeaderComposer` injects shared header/footer data into every view; `LogsActivity` records CUD actions to `activity_logs`.

Models live in `app/Models/` and are **shared** — modules consume them, never redeclare them. See [`documents/PROJECT_OVERVIEW.md`](documents/PROJECT_OVERVIEW.md) §5 for the full set of development conventions (localization, RBAC, soft deletes, module boundaries, performance).

---

## Feature summary

**Public site:** homepage, global live search, services (+ sub-services), engineering projects (+ categories/subcategories, floors, components, costs, feasibility toggle), real-estate offers (multi-emirate pricing, video/virtual tours), portfolios, showcases, interior-design gallery, blog/news, about, team & board, branches, partners, contact (throttled), careers with resume upload, favourites/wishlist (share by token & email), EN/AR localization, XML + HTML sitemaps, under-construction mode.

**Admin (CMS):** dashboard + integration-health check, custom analytics (visitors, real-time, geolocation, journeys, CSV export), full CRUD for all content with soft-delete/trash/restore, feasibility studies (create-from-project, duplicate, force-delete), home-page builder (sections/blocks/banners/sliders), SEO Pages editor, Google-Translate helper, menus, users/roles/permissions, activity log, site settings.

**CRM:** contact-us inbox (assign agent, status, notes, threaded replies), favourites management (assign, comment, email/notify, Excel export), agents, job postings.

**Cross-cutting:** route-level RBAC with super-admin bypass, full audit logging, custom analytics with heartbeat, soft-deletes everywhere, per-page SEO metadata, multi-emirate/multi-currency offer pricing, EN/AR everywhere.

Full catalogue: [`documents/PROJECT_OVERVIEW.md`](documents/PROJECT_OVERVIEW.md) §4.

---

## Requirements

- PHP **8.1+**
- Composer 2
- MySQL 5.7+ / 8
- Node.js 18+ & npm
- PHP extensions: `gd` (image processing), `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`

---

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate

# configure DB + mail + APP_URL in .env, then:
php artisan migrate --seed
php artisan storage:link          # links public/storage -> storage/app/public

npm install && npm run build       # or: npm run dev
php artisan serve
```

- Enable/disable a module without touching code via [`modules_statuses.json`](modules_statuses.json).
- Set `UNDER_CONSTRUCTION=true` in `.env` to show the construction page to the public while admins keep access.

---

## Deployment

This app is deployed on cPanel/LiteSpeed. After uploading:

```bash
php artisan migrate --force
php artisan storage:link          # if not already linked
php artisan optimize:clear        # clear config/route/view caches
php artisan config:cache          # re-cache config (after APP_URL is correct)
npm run build                     # if assets changed
```

**Critical production settings:**

- **`APP_URL=https://svec.ae`** — absolute URLs (sitemap, emails) are built from this. If it's wrong, the sitemap emits broken links.
- **Document root** is set to the `public/` directory, so `public/.htaccess` is the active rewrite file (the root `.htaccess` mirrors the same canonical/redirect rules as a fallback).
- After deploying, clear PHP **OPcache** (restart PHP in cPanel) so updated controllers take effect.
- Verify: `curl -sI https://svec.ae/public/en/offers` should `301` to the clean URL; `curl https://svec.ae/sitemap.xml` should list `https://svec.ae/...` URLs.

---

## SEO & URL handling

The platform includes a comprehensive SEO layer (see the [content-team guide](documents/SEO_CONTENT_TEAM_GUIDE.md)):

- **Canonical + hreflang (EN/AR)** on every page; `/public/` and query strings stripped from canonicals.
- **Legacy-URL 301s** — `app/Http/Middleware/LegacyRedirect.php` + [`config/legacy_redirects.php`](config/legacy_redirects.php) redirect old-site URL families and exact `url_redirects` table entries.
- **Slug stability** — `RecordsSlugRedirects` auto-creates a 301 when a slug changes; `HasUniqueSlug` prevents duplicate-slug collisions (500s).
- **Host/scheme canonicalization** — `www → non-www`, `http → https`, `/index.php → /`, `/public/ → clean` (in both `.htaccess` files).
- **Sitemap** — dynamic `/sitemap.xml` (`SitemapController`), regenerated on every request; **no build step**.
- **robots.txt** — blocks admin/private paths, advertises the sitemap.
- **Thin-page control** — paginated/filtered listings emit `noindex, follow`; empty categories return a real 404.
- **Structured data** — Organization/LocalBusiness JSON-LD, populated from the contact-information record.

**Content editors:** what to fill and how is documented in [`documents/SEO_CONTENT_TEAM_GUIDE.md`](documents/SEO_CONTENT_TEAM_GUIDE.md).

---

## Common commands

```bash
php artisan migrate --force              # run migrations (production-safe)
php artisan storage:link                 # (re)create the public storage symlink
php artisan optimize:clear               # clear config/route/view/cache
php artisan feasibility:clear --force    # wipe feasibility-study data
php artisan queue:work                   # process queued jobs (mail, notifications)
php artisan tinker                        # REPL for quick DB checks
```

---

## Documentation index

All project documentation is in [`documents/`](documents/):

| Document | Purpose |
|---|---|
| [`PROJECT_OVERVIEW.md`](documents/PROJECT_OVERVIEW.md) | Deep architecture, feature catalogue, and 14 development-focus areas |
| [`SEO_CONTENT_TEAM_GUIDE.md`](documents/SEO_CONTENT_TEAM_GUIDE.md) | Content-team playbook for SEO fields, rules, and known limitations |
| [`SVEC_WEBSITE_TICKETS.md`](documents/SVEC_WEBSITE_TICKETS.md) | Bilingual support-ticket catalogue for the ticketing system |
| [`MEMORY_OPTIMIZATION_GUIDE.md`](documents/MEMORY_OPTIMIZATION_GUIDE.md) | Memory-tuning notes for heavy listing pages |
| [`FEASIBILITY_STUDY_QUICK_START_GUIDE.md`](documents/FEASIBILITY_STUDY_QUICK_START_GUIDE.md) | Feasibility-study module entry point |
| [`FEASIBILITY_STUDY_DEVELOPMENT_PLAN.md`](documents/FEASIBILITY_STUDY_DEVELOPMENT_PLAN.md) | Feasibility-study design & plan |
| [`FEASIBILITY_STUDY_IMPLEMENTATION_SUMMARY.md`](documents/FEASIBILITY_STUDY_IMPLEMENTATION_SUMMARY.md) | Feasibility-study implementation notes |
| [`FEASIBILITY_STUDY_BUGFIXES.md`](documents/FEASIBILITY_STUDY_BUGFIXES.md) | Feasibility-study bug-fix log |

---

*Internal project for Smart Vision Engineering Consultants (SVEC). Built on the Laravel framework (MIT-licensed).*
