# Codebase Map - Where Every Feature Lives

> How to find the reusable logic for each mobile feature: the model, table, key migrations,
> the web controller + method that already implements the behavior, its route, and its views.
> When building an API endpoint, open the listed controller method and copy its query
> (filters, eager-loads, publish gate) into your `Api\V1` controller.

Conventions recap (details in [00_OVERVIEW_AND_CONVENTIONS.md](00_OVERVIEW_AND_CONVENTIONS.md)): published = `publish_status = 0`; featured = `home_status = 0`; soft-deleted rows excluded via `whereNull('deleted_at')`; bilingual `*_english` / `*_arabic` columns; images served as `url('/storage' . $path)`.

---

## 1. Projects

| Concern | Location |
|---------|----------|
| Model | [app/Models/Project.php](app/Models/Project.php) (table `projects`), gallery [app/Models/ProjectImage.php](app/Models/ProjectImage.php) (table `project_images`) |
| Base migration | [database/migrations/2025_10_21_110000_create_projects_table.php](database/migrations/2025_10_21_110000_create_projects_table.php) (+ many `*_projects_table.php` alters for images, emirate, code, number, seo_title, alt_text) |
| List / filter / sort | [ProjectsController::index](app/Http/Controllers/ProjectsController.php) and `featured` (home_status=0); private `applyFilters()` + `applySorting()` hold the exact filter logic |
| Detail | [ProjectsController::show](app/Http/Controllers/ProjectsController.php) - `firstOrFail()` by slug with a large eager-load set |
| Spec values (AJAX) | `ProjectsController::getSpecificationValues` |
| Routes | [routes/web.php](routes/web.php): `projects.index`, `projects.featured`, `projects.show`, `projects.specification-values` (localized group) |
| Views | `resources/views/pages/projects/index.blade.php`, `project.blade.php`, `featured/featured.blade.php` |
| Taxonomy | `EngineeringCategory`, `EngineeringSubCategory` ([category route](app/Http/Controllers/CategoryController.php), [subcategory route](app/Http/Controllers/EngineeringSubCategoryController.php)), `ProjectType`, `ProjectStyle`, `Specification` (pivot `ProjectSpecification`), `Emirate` |

Key columns: `title_english/arabic`, `slug`, `main_image`, `cover_image`, `page_image`, `site_image`, `plan_2d_image` (PDF), `plan_3d_image`, `video_url`, `tour_url`, `sqft`, `sqm`, `description_english/arabic`, `bio_english/arabic`, `location_english/arabic`, `project_cost`, `seo_*`, `category_id`, `subcategory_id`, `type_id`, `style_id`, `emirate_id`, `partner_id`, `currency_id`, `publish_status`, `home_status`. No `$casts` (uses `$guarded = []`).

---

## 2. Offers

| Concern | Location |
|---------|----------|
| Model | [app/Models/Offer.php](app/Models/Offer.php) (table `offers`); gallery [app/Models/OfferImage.php](app/Models/OfferImage.php) (`offer_images`); pricing [app/Models/OffersPrices/OfferPrice.php](app/Models/OffersPrices/OfferPrice.php) (`offer_prices`) |
| Migrations | [database/migrations/2025_12_20_100001_create_offers_table.php](database/migrations/2025_12_20_100001_create_offers_table.php), `..._create_offer_prices_table.php`, `..._create_offer_images_table.php` |
| List / filter / sort | [OffersController::index](app/Http/Controllers/OffersController.php), `category`, `subcategory`; private `applyFilters()`, `applySorting()` (incl. price subqueries), `processOffers()` (price selection) |
| Detail | [OffersController::show](app/Http/Controllers/OffersController.php) - eager-loads prices, floors, feasibility; computes `selected_price` / `default_price` / `all_prices` |
| Routes | [routes/web.php](routes/web.php): `offers.index`, `offers.category`, `offers.subcategory`, `offers.show` |
| Views | `resources/views/pages/offers/index.blade.php`, `show.blade.php`, `category.blade.php`, `subcategory.blade.php` |
| Taxonomy | `OfferCategory`, `OfferSubCategory`; shared `ProjectType`, `ProjectStyle`, `Specification`, `Emirate` |

Pricing model: price is NOT on `offers`. Each offer has many `offer_prices` rows (`offer_id`, `emirate_id`, `price`, `notes_english/arabic`, `status` where `0` = active). Price shown depends on selected emirate -> primary emirate (`Emirate::getPrimary()`) -> first available. Reuse `processOffers()`.

---

## 3. Interior Design

| Concern | Location |
|---------|----------|
| Model | [app/Models/InteriorDesignGallery.php](app/Models/InteriorDesignGallery.php) (table `interior_design_galleries`) |
| Migration | [database/migrations/2026_01_19_110000_create_interior_design_galleries_table.php](database/migrations/2026_01_19_110000_create_interior_design_galleries_table.php) |
| List / filter | [InteriorGalleryController::index](app/Http/Controllers/InteriorGalleryController.php), `category` |
| Detail | `InteriorGalleryController::show` EXISTS but 404s (no `pages/interior/show.blade.php`); the web shows detail via a modal on the listing. The API SHOULD expose real detail (see [03_CONTENT_API.md](03_CONTENT_API.md)). |
| Routes | `interior.index`, `interior.category`, `interior.show` |
| Views | `resources/views/pages/interior/index.blade.php`, `category.blade.php` |
| Taxonomy | `InteriorCategory` (table `interior_categories`); shared `ProjectStyle` (via `project_style_id`), `ProjectType` (required `project_type_id`), `Emirate`; optional link to `Project` via `project_id` |

Single `image` column (no gallery child table). `scopePublished()` / `scopeShowOnHome()` defined. Sort options: `newest` (`ordering ASC, created_at DESC`), `oldest`, `title_asc`, `title_desc`.

---

## 4. Authentication & Account

| Concern | Location |
|---------|----------|
| User model | [app/Models/User.php](app/Models/User.php) (`account_type`, `is_active`, `phone`, `preferred_locale`, `source`, `consent_at`, `password_set_at`, `pending_email`, `notification_prefs`, ERP ids). Helpers `isCustomer()`, `scopeCustomers()`, `acceptsDirectEmail()` |
| API auth (exists) | [app/Http/Controllers/Api/CustomerAuthController.php](app/Http/Controllers/Api/CustomerAuthController.php) - register/login/me/logout |
| API profile (exists) | [app/Http/Controllers/Api/CustomerProfileController.php](app/Http/Controllers/Api/CustomerProfileController.php) - show/update/updatePassword |
| Shared registration logic | [app/Services/CustomerRegistrationService.php](app/Services/CustomerRegistrationService.php) - `register($data, $source)`, `sendInvite($user)` |
| Web forgot/reset (reuse for API) | [app/Http/Controllers/Auth/CustomerForgotPasswordController.php](app/Http/Controllers/Auth/CustomerForgotPasswordController.php), [CustomerPasswordController.php](app/Http/Controllers/Auth/CustomerPasswordController.php) |
| Web resend activation | [CustomerRegisterController::resendActivation](app/Http/Controllers/Auth/CustomerRegisterController.php) |
| Routes | [routes/api.php](routes/api.php) (customer group), [routes/web.php](routes/web.php) (web auth) |
| Password brokers | [config/auth.php](config/auth.php): default `password_reset_tokens` (reset) + `invitations` broker `customer_invitation_tokens` (activation, 48h) |

---

## 5. Favourites

| Concern | Location |
|---------|----------|
| Model | [app/Models/Favourite.php](app/Models/Favourite.php) (table `favourites`) |
| Migration | [database/migrations/2026_02_26_000001_create_favourites_table.php](database/migrations/2026_02_26_000001_create_favourites_table.php) |
| Public controller | [app/Http/Controllers/FavouriteController.php](app/Http/Controllers/FavouriteController.php) - `index`, `toggle`, `remove`, `clear`, `count`, `sendEmail`, `shared` |
| Routes | [routes/web.php](routes/web.php): `/favourites/*` (no auth; session/cookie identity) |
| Identity | `Favourite::getSessionId()` - cookie `favourite_session_id` (30d) or session UUID. NOT linked to `user_id` (see [08_GAPS_AND_BACKEND_CHANGES.md](08_GAPS_AND_BACKEND_CHANGES.md)) |

Columns: `session_id`, `item_type` (`project|offer|interior`), `item_id`, `emirate_id`, `price`, `name`, `email`, `mobile`, `is_permanent`, `expires_at`. Unique on `(session_id, item_type, item_id)`. Not a polymorphic morph - a manual `$itemModels` map resolves `item_type` to `Project` / `Offer` / `InteriorDesignGallery`.

---

## 6. Inquiries / Contact

| Concern | Location |
|---------|----------|
| Model | [app/Models/ContactUs.php](app/Models/ContactUs.php) (table `contact_us`) |
| Migration | [database/migrations/2025_11_09_221827_create_contact_us_table.php](database/migrations/2025_11_09_221827_create_contact_us_table.php) |
| Public controller | [app/Http/Controllers/ContactController.php](app/Http/Controllers/ContactController.php) - `store()` with honeypot + time-trap + reCAPTCHA + content spam filter |
| Routes | `contact` (GET), `contact.store` (POST, `throttle:5,1`) |
| CRM (staff) | `Modules/CRM/App/Http/Controllers/ContactUsController.php` |

`contact_us` columns: `name`, `subject`, `email`, `phone`, `message`, `service_id`, `status`, `agent_id`, `notes`. It has NO `project_id` / `offer_id` / `user_id`. Project/offer inquiry forms in the views are UI stubs (env-gated, no backend). See [06_INQUIRIES_API.md](06_INQUIRIES_API.md).

---

## 7. Menu, Header & Site Data

| Concern | Location |
|---------|----------|
| Menu models | [app/Models/Menu.php](app/Models/Menu.php) (`menus`), [app/Models/MenuItem.php](app/Models/MenuItem.php) (`menu_items`), [app/Models/MenuSetting.php](app/Models/MenuSetting.php) |
| Menu build | `Menu::getHeaderMenu()` -> `getHierarchicalItems()` -> `buildTree()`; footer via `Menu::getFooterQuickLinksMenu()` / `getFooterCompanyMenu()` |
| URL/title resolution | `MenuItem::getUrl()`, `getTitle()`, `getDynamicChildren()`, `getQueryResults()`, `getCategorySubcategories()` (handles `item_type`: static, dynamic_*, dynamic_query, category_with_subs, divider, header) |
| Global data composer | [app/Http/View/Composers/HeaderComposer.php](app/Http/View/Composers/HeaderComposer.php) - injects menus, category trees, services, contact info into all views |
| Contact/site model | [app/Models/ContactInformation.php](app/Models/ContactInformation.php) (table `contact_information`) - `getContactInfo()` singleton. Cols: `email`, `mobile`, `secondary_mobile`, `whatsapp`, `facebook`, `instagram`, `linkedin`, `twitter`, `pinterest`, `location_text_*`, `location_map`, `footer_bio_*`. (No `phone`/`logo`/`hours`; logo is static `/pic/logos/logo{en,ar}.png`.) |
| About model | [app/Models/AboutInformation.php](app/Models/AboutInformation.php) (table `about_information`) - `getAboutInfo()` singleton. Cols (bilingual `*_english/arabic`): `title`, `subtitle`, `about`(+`about_image`), `mission`(+img), `vision`(+img), `values`+`values_points`(+img), `page_cover_image`, `company_profile` (PDF). Used by [ContactController::index](app/Http/Controllers/ContactController.php) |
| Migrations | `database/migrations/2026_01_30_00000*_*.php` (menus/items/settings), `2026_02_13_000001_*` (category_with_subs), `2025_10_31_000000_create_contact_information_table.php` |
| Helpers | [app/Helpers/helper.php](app/Helpers/helper.php): `getHeaderMenu()`, `getMenuByLocation()`, etc. |

Note: the app's bottom tab bar on the website is hardcoded (`resources/views/includes/mobile-bottom-nav.blade.php`) and is NOT driven by `menu_items`; the mobile app should define its own tab bar and use `/api/v1/menu` for the drawer/nav content.

---

## 8. Cross-cutting helpers to reuse

- reCAPTCHA v3: [app/Services/RecaptchaService.php](app/Services/RecaptchaService.php) (`isEnabled()`, `verify()`).
- Disposable-email rule: [app/Rules/DisposableEmail.php](app/Rules/DisposableEmail.php).
- Global search + filter lookups: [app/Http/Controllers/GlobalSearchController.php](app/Http/Controllers/GlobalSearchController.php) (already returns app-friendly JSON with absolute image URLs).
- Primary emirate: `Emirate::getPrimary()` for default offer pricing.
