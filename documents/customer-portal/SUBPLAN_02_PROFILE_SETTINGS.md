# Sub-Plan 02: Customer Profile, Settings & Password Reset (Internal)

> Derived from [CUSTOMER_PORTAL_MASTER_PLAN.md](CUSTOMER_PORTAL_MASTER_PLAN.md) (§7.3, §7.4) plus one gap
> [SUBPLAN_01_USERS_AND_REGISTRATION.md](SUBPLAN_01_USERS_AND_REGISTRATION.md) left open: a customer
> forgot/reset password flow.
> Scope is deliberately narrowed to what can ship WITHOUT ERPNext. ERP stays deferred behind the
> existing `CustomerSyncService` seam (Sub-Plan 01 §6), so it plugs in later with no rework.

---

## 1. Scope

**In scope (build now):**
1. Customer **Profile** page (read-only view of the account).
2. Customer **Profile Settings**: edit details (name, phone, email), change password (requires current password), preferred locale, notification toggles.
3. **Forgot / reset password** flow for customers (Sub-Plan 01 only shipped the invite/set-password path).
4. **Email change with re-verification**: a new email only becomes active after the customer clicks a signed link sent to the new address.

**Out of scope (later sub-plans):**
- ERPNext connection (sync/webhook) - master plan §7.6. Reuse the seam in §6 below.
- CRM registered-customers list + send-email - master plan §7.8.
- Customer project/contract/payments pages - master plan §7.9.

**Optional / secondary (include only if time permits):**
- Mirror API endpoints for app parity (`GET/PUT /api/customer/profile`, change-password) guarded by a new `customer:write` ability.

**Guiding rule:** every write that would touch ERP goes through `CustomerSyncService::pushProfileUpdate()`
(no-op today via `NullCustomerSyncService`), so profile/settings work standalone and ERP is a drop-in later.

---

## 2. Deliverables

- Additive migration adding `pending_email`, `pending_email_token`, `notification_prefs` to `users`.
- Updated `User` model (`$fillable` + `$casts` for the new columns; `notification_prefs` cast to array).
- `Account\ProfileController@show` - profile view.
- `Account\ProfileSettingsController` (`edit`, `updateDetails`, `updatePassword`, `updatePreferences`, `verifyNewEmail`).
- `Auth\CustomerForgotPasswordController` (`showRequestForm`, `sendResetLink`).
- FormRequests: `ProfileDetailsRequest`, `ChangePasswordRequest`, `PreferencesRequest`.
- Localized Blade: `profile`, `settings` (tabbed), `auth/forgot-password`; account nav links; login-page "Forgot password?" link.
- `pushProfileUpdate()` seam wired into the details/preferences update path (no-op now).
- Routes under the locale group (`auth` + `customer`) with no collisions against Sub-Plan 01.

---

## 3. Data model (this sub-plan)

Additive migration on `users` (all nullable, no data backfill needed):
- `pending_email` string nullable - the not-yet-verified new address during an email change.
- `pending_email_token` string nullable - token backing the signed verification link.
- `notification_prefs` json nullable - e.g. `{"email_updates": true, "project_updates": true}`.

`preferred_locale`, `password_set_at`, `is_active`, `phone` already exist from Sub-Plan 01. No new tables.

`User` model changes:
- Add `pending_email`, `pending_email_token`, `notification_prefs` to `$fillable`.
- Cast `notification_prefs` => `array`.
- Profile changes are audited automatically by the existing `App\Traits\LogsActivity` trait already on `User`.

---

## 4. Route & naming decisions (no collisions with Sub-Plan 01)

Sub-Plan 01 already defined: `account.dashboard`, `account.register`, `account.register.submit`,
`account.password.set` (GET, consumes token), `account.password.update` (POST, consumes token).

New routes, all inside the locale group in [routes/web.php](../../routes/web.php):

| Method | URI (under locale) | Name | Middleware |
|---|---|---|---|
| GET | `/account/profile` | `account.profile` | `auth`, `customer` |
| GET | `/account/settings` | `account.settings` | `auth`, `customer` |
| PUT | `/account/settings/details` | `account.settings.details` | `auth`, `customer` |
| PUT | `/account/settings/password` | `account.settings.password` | `auth`, `customer` |
| PUT | `/account/settings/preferences` | `account.settings.preferences` | `auth`, `customer` |
| GET | `/account/email/verify/{token}` | `account.email.verify` | `auth`, `customer`, `signed` |
| GET | `/forgot-password` | `password.request` | guest-friendly |
| POST | `/forgot-password` | `password.email` | `throttle:5,1` |

The reset link from `password.email` reuses Sub-Plan 01's `account.password.set` (GET) +
`account.password.update` (POST); no new reset-consumption code is needed.

---

## 5. Detailed steps

### Part A - Data model
1. Create the additive `users` migration (§3): `pending_email`, `pending_email_token`, `notification_prefs`.
2. [app/Models/User.php](../../app/Models/User.php): extend `$fillable` and cast `notification_prefs` to `array`.

### Part B - Profile page (master §7.3)
1. `app/Http/Controllers/Account/ProfileController@show` returns `pages.account.profile` with the authenticated user.
2. Localized Blade `resources/views/pages/account/profile.blade.php` (EN/AR, extends `layouts.master`): name, email + verification badge, phone, preferred locale, member-since; link to Settings; project-count placeholder (filled by a later sub-plan).
3. Owner-only by construction (uses `auth()->user()`); `customer` gate blocks staff.

### Part C - Profile settings (master §7.4)
1. `app/Http/Controllers/Account/ProfileSettingsController`:
   - `edit()` -> `pages.account.settings` (tabs: Details / Password / Preferences).
   - `updateDetails(ProfileDetailsRequest)` -> update `name`, `phone`; if `email` changed, DO NOT overwrite `email` - store `pending_email` + `pending_email_token`, email a signed verification link to the new address; then call `CustomerSyncService::pushProfileUpdate($user)`.
   - `updatePassword(ChangePasswordRequest)` -> `current_password` check then set new hash + `password_set_at`.
   - `updatePreferences(PreferencesRequest)` -> update `preferred_locale` + `notification_prefs`; call `pushProfileUpdate`.
   - `verifyNewEmail(Request)` -> on a valid signed token, move `pending_email` -> `email`, set `email_verified_at = now()`, clear pending fields.
2. FormRequests in `app/Http/Requests/Account/`:
   - `ProfileDetailsRequest`: `name` required; `phone` nullable; `email` `required|email|unique:users,email,{id}` (ignore self) and also not equal to another user's `pending_email`.
   - `ChangePasswordRequest`: `current_password` (Laravel `current_password` rule) + `password` `min:8|confirmed`.
   - `PreferencesRequest`: `preferred_locale` in `[en, ar]`; `notification_prefs.*` boolean.
3. Blade `resources/views/pages/account/settings.blade.php` (EN/AR, tabbed) posting to the three PUT routes; show a "pending email verification" notice when `pending_email` is set.

### Part D - Forgot / reset password (fills the Sub-Plan 01 gap)
1. `app/Http/Controllers/Auth/CustomerForgotPasswordController`:
   - `showRequestForm()` -> `pages.account.auth.forgot-password`.
   - `sendResetLink(Request)` -> validate `email`; send a reset link that targets `account.password.set` (reuse `CustomerInviteMail` with a `purpose` flag, or add a slim `CustomerPasswordResetMail`). Always return a uniform success message (no user enumeration).
2. Blade `resources/views/pages/account/auth/forgot-password.blade.php` (EN/AR, extends `layouts.master`), `throttle:5,1` on POST.
3. Add a "Forgot password?" link to [resources/views/auth/login.blade.php](../../resources/views/auth/login.blade.php), next to the existing register link.
4. Reset consumption is Sub-Plan 01's `Auth\CustomerPasswordController` (`account.password.set` / `account.password.update`) - unchanged; it already sets the password, verifies email, and logs the user in.

### Part E (optional) - App parity API
1. Add `customer:write` to the abilities issued in `Api\CustomerAuthController@login`.
2. `GET /api/customer/profile`, `PUT /api/customer/profile`, `PUT /api/customer/password` under `auth:sanctum` + `ability:customer:write`, delegating to a shared service so web and API share validation.

---

## 5A. Design & responsiveness (required)

All customer-portal pages MUST match the public front-end design and be fully mobile responsive.

- **Same shell:** every account page extends `layouts.master`, so it inherits the site topbar, header, footer, mobile bottom nav, fonts (Poppins/Tajawal), and `themes.css`. No standalone HTML documents (unlike the legacy admin `auth/login` page).
- **Hero + breadcrumb:** each page opens with a hero band + breadcrumb matching the pattern in [resources/views/pages/contact/partials/hero.blade.php](../../resources/views/pages/contact/partials/hero.blade.php) (gradient background, overlay, centered title/subtitle, `Home / ...` breadcrumb).
- **Front-end components/classes:** reuse the theme's Bootstrap-based building blocks used across the site - `container`, `row`, `col-lg-*`, `form-group`, `form-control`, `btn`, `alert alert-* alert-dismissible`, `section-label` + `section-title`, and FontAwesome (`fas`/`fab`) icons. Do NOT invent a parallel visual language.
- **Brand tokens:** use the theme palette (primary `#19868b`, dark `#172e38`, accent `#eff6f7`) via a dedicated stylesheet `public/assets/css/account-portal.css` included through `@section('css')`.
- **Account layout:** a shared two-column layout - left sidebar nav (Dashboard, Profile, Settings, Log out) + right content card - via partials `resources/views/pages/account/partials/{hero,nav}.blade.php`, reused by dashboard/profile/settings.
- **Mobile responsive:** mobile-first; the sidebar collapses above the content on small screens; forms go single-column under `768px`; tap targets >= 44px; no horizontal scroll at 320px. Verify at 320 / 375 / 768 / 1024 / 1440.
- **RTL:** must render correctly in Arabic (the layout already loads `rtl.css`/`arabic-global.css` for `ar`); avoid hard-coded `left/right` - use logical spacing utilities or mirror in the stylesheet.
- **Consistency pass:** update the existing Sub-Plan 01 views (`dashboard`, and ideally `auth/register`, `auth/set-password`) to the same hero + account layout so the portal is visually cohesive.
- **Accessibility:** labelled inputs, visible focus states, `aria` on tabs/alerts, and color contrast AA.

---

## 6. Deferred-ERP seam (reuse from Sub-Plan 01)

No new seam is introduced. `ProfileSettingsController` depends only on
`App\Services\CustomerSync\CustomerSyncService` and calls `pushProfileUpdate($user)` after a successful
details/preferences update. Today this resolves to `NullCustomerSyncService` (no-op). When the ERP
sub-plan lands, swap the container binding to `ErpNextCustomerSyncService` - no controller changes.

---

## 7. Permissions

None. These are customer-facing, owner-scoped routes gated by the `customer` middleware, not the RBAC
permission map. No seeder or `CheckRoutePermission` changes in this sub-plan.

---

## 8. Acceptance criteria

- Only the authenticated owner can view/edit their profile; unauthenticated -> login; staff blocked by `customer` gate.
- Details update enforces email uniqueness; changing email does NOT change the login email until the new address is verified via the signed link.
- Password change requires the correct current password; a wrong current password is rejected.
- Forgot-password returns a uniform response (no user enumeration); the emailed link sets a new password and logs the customer in.
- Preferred locale persists and affects subsequent page locale; notification toggles persist.
- ERP untouched: `pushProfileUpdate` is a no-op and settings succeed without it.

---

## 9. Testing

- Profile/settings: email-unique on edit, email-change re-verification path (old email stays until confirmed), name/phone validation.
- Change password: correct/incorrect `current_password`, confirmation rule.
- Forgot/reset cycle: valid link, expired/invalid token, non-existent email (uniform response).
- Preferences: locale + notification persistence; owner-only authorization (a customer cannot edit another's profile).

---

## 10. Execution checklist (order)

1. Additive migration (`pending_email`, `pending_email_token`, `notification_prefs`) + `User` fillable/casts.
2. Profile view (`ProfileController@show`) + route + localized Blade.
3. Settings (`ProfileSettingsController` + FormRequests) + tabbed Blade; wire `pushProfileUpdate` seam.
4. Email-change verification (signed `account.email.verify`).
5. Forgot-password controller + request Blade; reuse Sub-Plan 01 reset consumption; add login-page link.
6. (Optional) API profile endpoints + `customer:write` ability.
7. `php artisan migrate`; smoke test the flows; add feature tests.

---

## 11. Dependencies & notes

- Builds directly on Sub-Plan 01 (users schema, `account_type`, `customer` gate, `account.password.*` routes, `CustomerInviteMail`, `CustomerSyncService`).
- Mail must be configured in `.env` for the email-change verification and forgot-password links (fail-soft + logged if not, matching Sub-Plan 01).
- `APP_URL` must be correct so signed verification and reset links resolve.
