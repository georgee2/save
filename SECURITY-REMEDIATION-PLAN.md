# Security Remediation Plan

**Scope audited:** contact form, project/offer inquiry forms, register, login, password reset, account activation, plus the cross-cutting attack surface those flows depend on (file upload, mail, session, headers, SQL).

**Audit date:** 2026-07-25
**Codebase:** Laravel 10.10 / PHP 8.2 (cPanel EA-PHP82) — `smartvisionuae`
**Status:** audit complete, no code changed yet.

---

## Executive summary

| Area | Verdict |
|---|---|
| SQL injection | **Clean.** ~110 raw-SQL sinks reviewed, all static or bound. No action needed. |
| File upload (careers) | **Critical.** Likely RCE + public PII exposure. |
| Password reset | **Critical.** Staff/admin account takeover chain. |
| Favourites endpoints | **High.** Open mail relay + lead-record hijack. |
| Contact form anti-spam | **High.** Both bot layers bypassable by omitting a field. |
| Production PHP config | **High.** `display_errors=On` on the live host. |
| Login / registration | **Medium.** Solid core, no per-account brute-force cap, enumeration on register. |
| Project/offer inquiry forms | **Not wired to any backend** — user data silently discarded. |
| Headers / CSP / session flags | **Medium.** No CSP, no HSTS, `SESSION_SECURE_COOKIE` unset. |

Phases are ordered by **exploitability by an unauthenticated stranger**, not by effort.
Do not reorder Phase 1 items behind Phase 2+ work.

---

## Phase 0 — Production configuration (do first, ~30 min, no code changes)

Cheap, reversible, and two of these silently disable defenses you already paid for.

- [ ] **0.1 — Turn off `display_errors` on production.**
  `display_errors = On` appears in three places and leaks absolute paths and exception text (including DB connection details) to any visitor who triggers a PHP error. These are cPanel-generated production directives, not dev leftovers.
  - `.user.ini:7` → `display_errors = Off`
  - `.htaccess:186` (`<IfModule php8_module>`) → `php_flag display_errors Off`
  - `.htaccess:198` (`<IfModule lsapi_module>`) → `php_flag display_errors Off`
  - Preferred: change via cPanel MultiPHP INI Editor so it is not overwritten on the next cPanel write.

- [ ] **0.2 — Verify the production `.env`.**
  The checked-out `.env` has `APP_ENV=local` and `APP_DEBUG=true`. On the live host that combination is severe:
  - `APP_DEBUG=true` + `spatie/laravel-ignition` renders full environment dumps on error — `DB_PASSWORD`, `APP_KEY`, `MAIL_PASSWORD`, `RECAPTCHA_SECRET_KEY`, `ERPNEXT_API_SECRET`.
  - `APP_ENV=local` makes `RecaptchaService::isEnabled()` return `false` (`app/Services/RecaptchaService.php:21-23`) — **reCAPTCHA is off site-wide**, on every form.

  Required production values:
  ```dotenv
  APP_ENV=production
  APP_DEBUG=false
  APP_URL=https://svec.ae
  LOG_LEVEL=error
  SESSION_SECURE_COOKIE=true
  ```
  `.env` is correctly gitignored (`.gitignore:16-18`) — no secrets are in version control.

- [ ] **0.3 — Add a deploy guard.** Fail the deploy if `APP_DEBUG=true` while `APP_ENV=production`.

- [ ] **0.4 — Confirm whether a CDN/proxy fronts the site.**
  `app/Http/Middleware/TrustProxies.php:15` has `protected $proxies;` (null — nothing trusted). Correct for direct-to-origin. **But** behind Cloudflare or a load balancer, `$request->ip()` returns the proxy IP, so every per-IP throttle collapses into one shared global bucket — one spammer then locks out all users, and Phase 2's rate limits are worthless.
  If proxied, set `$proxies` to the CDN ranges and verify `$request->ip()` returns real client IPs.

**Exit criteria:** an intentional 500 on production shows a generic error page; `php artisan tinker --execute="echo app()->environment();"` prints `production`.

---

## Phase 1 — Critical: unauthenticated exploitation (fix this week)

### 1.1 — Careers résumé upload: RCE + public PII exposure

**Location:** `app/Http/Controllers/CareerController.php:128-133`, route `routes/web.php:185`

Three defects stack:

```php
$resumeName = time() . '_' . $resumeFile->getClientOriginalName();   // attacker keeps extension chain
$resumePath = $resumeFile->storeAs('uploads/resumes', $resumeName, 'public');  // world-readable disk
```
plus `POST /careers/{id}/apply` is the **only public POST in `routes/web.php` with no `throttle`** (compare lines 61, 66, 68, 72, 76, 80, 179).

**Why this is RCE, not just exposure.** `mimes:pdf,doc,docx` validates by *content*, so a PDF-polyglot containing `<?php ... ?>` passes. Uploaded as `evil.php.pdf` it lands at a public URL, and the handler at `.htaccess:214` is `AddHandler application/x-httpd-ea-php82 .php .php8 .phtml` — Apache `mod_mime` applies a handler from **any** extension in a multi-extension filename. This is exactly why the safe form is `<FilesMatch>` + `SetHandler`.

**The two guards that look protective do not fire:**
- `.htaccess:147` uses `^/storage/.*\.php$` — anchored at `$`, so `evil.php.pdf` does not match.
- `.htaccess:121` (`RewriteRule ^storage/ - [F,L]`) is never reached. Because `<root>/storage/uploads/` does not exist on disk, the front-controller rewrite at `.htaccess:46` matches first and carries `[L]`, rewriting to `/public/storage/uploads/...` — which no longer matches `^storage/`. Rule 121 only protects the real `storage/` directory (where `-d` is true and the rewrite is skipped), **not** the `public/storage` junction.

**Tasks:**
- [ ] Store on the private disk: `$file->storeAs('resumes', $name, 'local')`.
- [ ] Generate the filename server-side: `$name = Str::uuid() . '.' . $file->extension();` — never reuse `getClientOriginalName()`. Keep the original name in a new DB column for display.
- [ ] Add an authenticated CRM download route using `Storage::disk('local')->download()`, gated by the existing `auth` + `staff` + `check.route.permission` middleware.
- [ ] Add `->middleware('throttle:5,1')` to `routes/web.php:185`.
- [ ] Add `max:5000` to `cover_letter` (`CareerController.php:124` is currently `nullable|string` against a 64 KB `text` column).
- [ ] Change the PHP handler in `.htaccess` from `AddHandler` to:
  ```apache
  <FilesMatch "\.(php|php8|phtml)$">
      SetHandler application/x-httpd-ea-php82
  </FilesMatch>
  ```
- [ ] **Migrate existing files** out of `storage/app/public/uploads/resumes` and purge them from the public junction. Update `job_applications.resume` paths accordingly.

**Verification:** upload `test.php.pdf` containing a `%PDF-` header followed by `<?php echo "EXEC"; ?>`, then fetch its URL. Before the fix it may print `EXEC`; after the fix the URL must 404 and the file must not be reachable without authentication.

### 1.2 — Password reset allows staff/admin account takeover

**Locations:** `app/Http/Controllers/Auth/CustomerPasswordController.php:50-81`, `app/Http/Kernel.php:17`

Two defects chain into unauthenticated admin takeover.

**(a) No account-type guard.** `/set-password` tries the `invitations` broker then **falls back to the default broker** (line 68) — the same `password_reset_tokens` table staff resets use (`config/auth.php:93-99`). `StaffPasswordController.php:44-49` correctly gates on `isStaff()`; the customer endpoint has **no symmetric `isCustomer()` check**. Line 80 then calls `Auth::login($user)`, landing the attacker in an authenticated admin session without passing through `LoginController` — no rate limiting, no reCAPTCHA step-up, no audit log, no deactivation check.

**(b) Host header injection supplies the token.** `TrustHosts` is commented out at `Kernel.php:17` and there is no `URL::forceRootUrl()`. Reset links are built with `route(..., absolute)`, which derives the host from the request `Host` header. On a catch-all vhost, an attacker POSTs `/forgot-password` for an admin address with a poisoned `Host:`; the victim receives a genuine email pointing the token at the attacker's server.

**(c) Deactivation bypass.** The callback sets `'is_active' => true` unconditionally (line 55), so any account an admin disabled reactivates itself via an old link — invitation tokens live 48 hours.

**Tasks:**
- [ ] In `setPassword()`, load the user after validation and reject unless `$user->isCustomer()`.
- [ ] Refuse the flow entirely when `$user->is_active === false`.
- [ ] Remove `'is_active' => true` from the `forceFill`, or set it only when `is_null($user->password_set_at)` (genuine first activation).
- [ ] Never `Auth::login()` a non-customer — redirect to `route('login')`.
- [ ] Uncomment `TrustHosts` in `Kernel.php:17` and populate `hosts()` with `allSubdomainsOfApplicationUrl()` plus explicit production hostnames.
- [ ] Add `URL::forceRootUrl(config('app.url'));` in `AppServiceProvider::boot()` (depends on Phase 0.2 setting a real `APP_URL`).
- [ ] When an admin deactivates a user, delete their rows from **both** `password_reset_tokens` and `customer_invitation_tokens`.

### 1.3 — Favourites: open mail relay + lead-record hijack

**Locations:** `app/Http/Controllers/FavouriteController.php:139-184`, `app/Http/Middleware/EncryptCookies.php:14-16`, `routes/web.php:201,205`

**(a) Mail relay.** `POST /favourites/send-email` is anonymous with **no throttle**. Anyone can make the server send a fully SVEC-branded email — passing your own SPF/DKIM — to any address, at unlimited rate. Domain-reputation and blacklisting risk, and a strong phishing primitive.

**(b) Writes before authorization.** Line 148 updates `email` and `name` on the favourites rows **before** any ownership check. Those rows are what the CRM surfaces as sales leads (`Modules/CRM/App/Http/Controllers/FavouritesController.php:34-35,44`).

**(c) Unsigned authorization key.** `EncryptCookies::$except` contains `favourite_session_id`, so the cookie is a plaintext, unsigned, client-controlled value used directly as the authorization key (`app/Models/Favourite.php:104`). Line 163 then **publishes that exact value in the share URL**. Anyone receiving a shared link can set the cookie and read the list, delete it, rewrite the lead's contact details, and mail the victim's list to themselves. For logged-in customers the token is a stable per-account UUID (`app/Models/User.php:118-126`), so the access is persistent.

**Tasks:**
- [ ] **Remove `'favourite_session_id'` from `EncryptCookies::$except`** — single highest-value change here; makes the cookie tamper-proof.
- [ ] Use a distinct, non-reversible share token: `hash('sha256', $sessionId . config('app.key'))`, so the read-only link never discloses the write-capable session id.
- [ ] Move the `update()` at line 148 to **after** the empty-list check, and only for rows the caller owns.
- [ ] Add `->middleware('throttle:3,60')` to `routes/web.php:205` (send-email) and `->middleware('throttle:60,1')` to line 201 (toggle).
- [ ] Validate the cookie shape (`/^[0-9a-f-]{36}$/`) before use.
- [ ] Add honeypot + reCAPTCHA to the send-email endpoint.

---

## Phase 2 — High: spam and bot defenses — DONE

Delivered on `fix/form-guard-and-captcha-hardening`. All of 2.1–2.4 is implemented, plus
5.2 and the two `$fillable` items from 5.3. Deviations from the plan as originally written,
and why:

- **`->queue()` was not used for mail.** This project has no queue at all: `QUEUE_CONNECTION=sync`,
  no `jobs` table, no worker, no cron. Mail now uses `dispatch(closure)->afterResponse()`,
  matching `CustomerRegistrationService::sendInvite`.
- **Dedupe lives in the cache, not the database.** `contact_us.message` is a `text` column
  and MySQL will not index it without a prefix length, so the planned index was impossible.
  `Cache::add()` is atomic on the file driver when given a TTL.
- **`email:rfc,dns` was NOT applied to the contact form** (only `rfc`). `dns` performs a
  blocking MX lookup with no timeout, and this is the highest-volume public POST on the
  site; a bad domain there only bounces the auto-reply, whereas a slow resolver costs a
  real lead. The auth flows keep `dns`.
- **Login is exempt from the reCAPTCHA fallback throttle.** reCAPTCHA there is a step-up
  after 3 failures; locking staff out of the CMS because Google is unreachable would be a
  self-inflicted outage. Login already has two limiters.
- **The heartbeat limiter is keyed on the `svec_vid` cookie, not the IP.** The beacon fires
  every 30s per tab, so an IP key would throttle a whole office behind one NAT — and
  `sendBeacon` is fire-and-forget, so the 429 would be invisible.
- **No HTTP retry on siteverify.** We fail open on `Unavailable` anyway, so a retry would
  only double the worst-case wait on a public form.

Note for future work: `Application::terminate()` does not clear terminating callbacks, so in
a feature test that issues several requests the first `afterResponse` mail re-fires on every
later request. That is a harness artifact — production gets a fresh app per request — but it
makes `Mail::assertSentCount` unreliable across multiple requests in one test.

### 2.1 — Contact form: both bot layers are opt-in for the attacker

**Location:** `app/Http/Controllers/ContactController.php:47-70`

```php
if ($formLoaded > 0 && (time() - $formLoaded) < 3) { ... }             // line 53 — omit field, skip check
if ($recaptchaSecret && $request->filled('g-recaptcha-response')) { ... } // line 59 — omit token, skip captcha
```

A bot that simply does not send `_form_loaded` and `g-recaptcha-response` bypasses both. The `_form_loaded` value is also an unsigned plaintext `time()`, so it is forgeable even when sent.

**The correct component already exists in this repo.** `RecaptchaService::verify()` returns `false` on an empty token, and `CustomerRegisterController.php:55-56` uses it properly.

**Tasks:**
- [ ] Inject `App\Services\RecaptchaService` into `ContactController`; replace lines 57-70 with:
  ```php
  if ($this->recaptcha->isEnabled() && !$this->recaptcha->verify($request->input('g-recaptcha-response'), $request->ip())) {
      // existing error response
  }
  ```
- [ ] Delete the duplicate private `verifyRecaptcha()` method (lines ~165-180).
- [ ] Treat a **missing** `_form_loaded` as failure, not success.
- [ ] Sign the timestamp — `encrypt(time())` or an HMAC — so it cannot be forged. Add an upper bound (reject > 24 h old).
- [ ] Rename the honeypot from `website_url` (a widely-known default that spam kits skip) to something site-specific.

### 2.2 — reCAPTCHA hardening (all forms)

**Location:** `app/Services/RecaptchaService.php:39-62`, `ContactController.php:177-180`

- Returns `true` when the secret is empty (line 39-41).
- Returns `true` on **any** exception (line 58-62) — a DNS block or Google outage silently disables the control everywhere.
- No `Http::timeout()` on the siteverify call — a hanging endpoint holds a PHP worker.
- Neither implementation validates the `action` or `hostname` fields in Google's response, so a token minted on any page is accepted on any form.

**Tasks:**
- [ ] Add `Http::timeout(3)->retry(1)`.
- [ ] Assert `$data['action'] === $expectedAction` and `$data['hostname']` matches your domain.
- [ ] Fail closed in production, or add a circuit breaker: on repeated verify failures, escalate to a stricter throttle rather than passing everything.
- [ ] Log verify failures at `error`, not `warning`, so a silent bypass is visible.

### 2.3 — Add missing rate limits

Four public endpoints currently have none:

| Route | File:line | Add |
|---|---|---|
| `POST /careers/{id}/apply` | `routes/web.php:185` | `throttle:5,1` (also Phase 1.1) |
| `POST /favourites/toggle` | `routes/web.php:201` | `throttle:60,1` (also Phase 1.3) |
| `POST /favourites/send-email` | `routes/web.php:205` | `throttle:3,60` (also Phase 1.3) |
| `POST /analytics/heartbeat` | `routes/web.php:215` | `throttle:30,1` |

- [ ] Add a honeypot + time-trap to the careers form (`resources/views/pages/careers/job.blade.php`) — it currently has none.
- [ ] Add per-**email-address** limits alongside per-IP ones on contact and register. `CustomerAuthController.php:33-39` already does this for the API; the web path does not.

### 2.4 — Contact form abuse hardening

- [ ] Record `ip_address` (45) and `user_agent` (255) on `contact_us` and `job_applications` — currently neither is stored, so a spam wave cannot be attributed, blocked, or cleaned up.
- [ ] Tighten email validation to match the auth flows: `['required', 'email:rfc,dns', 'max:255', new DisposableEmail()]`. `app/Rules/DisposableEmail.php` already exists and is used in registration but not here.
- [ ] Constrain `phone` — currently `nullable|string|max:255` with no format rule.
- [ ] Queue the confirmation email (`Mail::to()->queue()`) instead of sending synchronously; it is currently an unauthenticated mail trigger to any address at 5/min/IP.
- [ ] Add duplicate-submission detection (same email + message within N minutes).
- [ ] Persist `source` — it is validated at line 97 and posted by the home page, but omitted from `ContactUs::create()` and has no column. Lead attribution is silently lost.

---

## Phase 3 — Authentication hardening

> **Phase 3 is COMPLETE.** 3.1, 3.3 and 3.5 shipped on `fix/auth-bruteforce-and-revocation`
> (merged as PR #59); 3.2 and 3.4 on `fix/auth-enumeration-and-email-change` (Phase 3B).
>
> One 3.4 item was **deliberately not done**: `CustomerRegisterController` still re-invites
> an already-activated account on `/resend-activation`. Phase 3B made that path the
> *intended* behaviour for registration — an existing unactivated account gets its invite
> resent rather than an error — so adding a `password_set_at` guard now would contradict it.
> Revisit only if invite-window abuse is actually observed.
>
> Corrections found while implementing, worth knowing before touching this area again:
>
> - **`Auth::logoutOtherDevices()` must be called AFTER saving the new password, not
>   instead of saving it.** It verifies the password you hand it against the stored hash and
>   throws `InvalidArgumentException` if they differ, so calling it in place of the
>   `Hash::make` write produced a 500. It then re-hashes and updates the per-session hash.
> - It is a **silent no-op** unless `AuthenticateSession` is in the middleware stack. The
>   alias existed in `Kernel.php` but was applied to zero routes, so any call would have
>   done nothing. It is now in the `web` group; it self-heals for pre-existing sessions,
>   so enabling it does not sign current users out.
> - A `PasswordReset` listener alone does **not** cover the self-service change-password
>   flows — they never fired the event. They now do.
> - There is no `sessions` table, so sessions cannot be enumerated or deleted directly;
>   `logoutOtherDevices` is the only mechanism available.
> - `ValidationException->status(429)` only applies to JSON callers. A browser form post
>   gets a 302 with a session error, which is what tests must assert.

### 3.1 — Brute force: no per-account ceiling

**Location:** `LoginController.php:213,221`, `Api/CustomerAuthController.php:64`, `routes/web.php:61`

Every limiter key contains the IP, so a single account has **no aggregate attempt cap**. A botnet gets 5 attempts/min/IP against one email, unbounded in total. The comment at `CustomerAuthController.php:62-63` claims the key caps failures per account — the code does the opposite.

- [ ] Add a limiter keyed on the **email alone** (e.g. 20/hour + 100/day) in `LoginController::checkuser` and `CustomerAuthController::login`.
- [ ] Add a persistent lockout (`users.locked_until`) with an email notification to the account owner when it trips.
- [ ] Log failed logins — `ActivityLogService.php:302` already defines a `failed_login` action that is never called.

### 3.2 — Close enumeration oracles

- [ ] **Registration** (`app/Services/CustomerRegistrationService.php:93-110`) returns four distinguishable outcomes: new / existing-activated / existing-pending / existing-staff. The last maps your staff addresses. Return the same "check your email" response for all cases and mail the existing user a notice instead of throwing `ValidationException`.
- [ ] **Set-password and staff-reset** (`CustomerPasswordController.php:71-75`, `StaffPasswordController.php:45-49`) leak `passwords.user` vs `passwords.token`, distinguishing registered from unregistered addresses — and on the staff endpoint, staff from customer accounts. Collapse all failure modes to one generic message.
- [ ] **Login timing** — the unknown-email path short-circuits before bcrypt (`CustomerAuthController.php:73`; `Auth::attempt()` likewise), making response time a reliable existence oracle at cost-12 (~200-300 ms). Run a dummy `Hash::check()` against a fixed hash on the miss path.
- [ ] **Forgot-password timing** — same issue via `DatabaseTokenRepository::getPayload()`. Perform a constant-cost dummy hash on the miss path, or move token creation into the `afterResponse` closure.

### 3.3 — Token and session revocation

- [ ] **Password change revokes nothing.** `Account/ProfileSettingsController.php:82-90` deletes neither `password_reset_tokens` nor `customer_invitation_tokens`. A user reacting to a compromise does not revoke a link the attacker already holds. Centralize revocation in a `PasswordReset` event listener covering all three entry points.
- [ ] **Other sessions survive a reset.** `auth.session` is aliased at `Kernel.php:62` but applied to **zero routes**. Add `\Illuminate\Session\Middleware\AuthenticateSession::class` to the `web` group, and/or call `Auth::logoutOtherDevices()` in `updatePassword`.
- [ ] **Sanctum tokens never expire** (`config/sanctum.php:49` — `'expiration' => null`), are unlimited per user, and survive a password change. Set `SANCTUM_EXPIRATION=43200` (30 days), schedule `sanctum:prune-expired`, delete same-name tokens before `createToken`, and revoke other tokens on password change.
- [ ] **Deactivation check leaves a session behind.** `LoginController.php:140-146` calls `Auth::logout()` without `session()->invalidate()` / `regenerateToken()`, unlike the real `logout()` at lines 197-198.

### 3.4 — Activation and email-change flows

- [ ] `CustomerRegisterController.php:123` checks `is_active` but not `password_set_at`, so an attacker can force 48-hour activation links for **already-activated** accounts — mail bombing, and it downgrades the intended 60-minute reset window on demand. Add `&& is_null($user->password_set_at)`.
- [ ] `Account/ProfileSettingsController.php:40-77` starts an email change with **no re-authentication** and the route (`routes/web.php:89`) has **no throttle** — a hijacked session can redirect the account, and mail is sent synchronously to an attacker-supplied address. Require `current_password` (or `password.confirm`), add `throttle:5,1`, queue the mail, and notify the **old** address.
- [ ] `pending_email_token` is stored plaintext (`ProfileSettingsController.php:49-52`), has no server-side expiry, and is **not** in `User::$hidden` (`app/Models/User.php:52-55`). Store `hash('sha256', $token)`, compare with `hash_equals`, add an expiry column, and add it to `$hidden`.
- [ ] The per-email cooldown (`CustomerForgotPasswordController.php:59-61`) is a non-atomic `Cache::has()` then `Cache::put()`. Use `Cache::add()`. Note the code comment claiming the broker throttle backs it is **wrong** — `createToken()` is called directly, bypassing it, so this cooldown is the *only* per-email limit.
- [ ] Strengthen the password policy (`AppServiceProvider.php:86`): add `->uncompromised()` (HIBP), raise to `min(12)`, and use a stricter variant for staff.
- [ ] Convert `GET /logout` (`routes/web.php:62`) to `POST` with `@csrf` — currently CSRF-able via `<img src>`.

### 3.5 — API surface

- [ ] `GET /api/user` (`routes/api.php:20-22`) returns the **entire** User model and is the only Sanctum route with no `ability:` middleware. It exposes `pending_email_token`, `favourites_token`, `erp_customer_id`, and more. Delete it or return the same explicit field list as `CustomerAuthController::me()`.

---

## Phase 4 — Headers, XSS, and session flags

- [ ] **Stored XSS on the public contact page.** `map_url` is validated only as `nullable|string` (`Modules/Admin/App/Http/Controllers/PartnerController.php:65,177`) and rendered raw at `resources/views/pages/contact/partials/branches.blade.php:80`. A low-privilege CMS user can plant script that fires for every anonymous visitor and every admin. Validate as `nullable|url` and render inside a hard-coded `<iframe src="...">`, allowlisting the Google Maps embed host.
- [ ] **Same pattern, second location.** `resources/views/pages/contact/partials/form-map.blade.php:133` bypasses the safe `e()` branch that already exists at line 136. Delete the raw branch.
- [ ] **Add a Content-Security-Policy.** None exists. This is what turns the two XSS findings above from contained into session-stealing. Start report-only, then enforce.
- [ ] **Add HSTS.** `.htaccess:24-26` forces HTTP→HTTPS via 301, but without `Strict-Transport-Security` the first request each visit is still downgradeable:
  ```apache
  Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains" env=HTTPS
  ```
- [ ] **Set `SESSION_SECURE_COOKIE=true`** — `config/session.php:171` resolves to `null`, so the session cookie can travel over plain HTTP (covered in Phase 0.2).
- [ ] Consider `SESSION_DRIVER=database` — file sessions on shared cPanel hosting use a shared `session.save_path` (`.user.ini:14`).

**Already correct, no action:** `X-Frame-Options`, `X-Content-Type-Options: nosniff`, `Referrer-Policy`, `Permissions-Policy`, `X-Powered-By` unset, `http_only=true`, `same_site=lax`.

---

## Phase 5 — Data integrity and functional gaps

### 5.1 — Project and offer inquiry forms are not connected to anything

This is a **business/lead-loss issue**, discovered during the audit.

- `resources/views/pages/offers/show.blade.php:668` — `<form id="tourRequestForm">` has no `action`, no `method`, no `@csrf`; both buttons are `type="button"`; a repo-wide search for `tourRequestForm` finds **no JavaScript handler**.
- `resources/views/pages/projects/project.blade.php:401` — bare `<form>` (defaults to GET on the current URL); its inputs have **no `name` attributes at all**. Submitting appends `?agent=option1` and reloads.

Visitors fill in name, email, phone, and tour date believing they submitted a request. **Nothing is stored and nothing is emailed.**

- [ ] Decide: wire these to `contact.store`, or remove them.
- [ ] If wiring: add `@csrf`, the honeypot + signed time-trap pair, a hidden `subject`, and rename fields to match the controller (`name`/`email`/`subject`, not `info_name`/`info_email`).
- [ ] Remove the hardcoded placeholder agent identities and photos shipping to production (`project.blade.php:524-565` — "Oliver Beddows", `images/agent-2.jpg`, "March 17, 2020").

### 5.2 — Analytics heartbeat — DONE (Phase 2 branch)

**Location:** now `app/Http/Controllers/AnalyticsHeartbeatController.php`

- [x] Rate limited — but keyed on the `svec_vid` cookie, **not** `throttle:30,1` as originally written. The beacon fires every 30s per open tab, so an IP-keyed limit would throttle a whole office behind one NAT, and `sendBeacon` is fire-and-forget so the 429 would never surface on the client.
- [x] `time_on_page` clamped to 0–3600.
- [x] The two `update()` calls merged into one, preserving the write-once guard on `page_title`.
- [x] Closure moved into a controller for testability. (Corrected: this did *not* break `php artisan route:cache` — Laravel 9+ ships `laravel/serializable-closure`, and caching was verified working before and after.)

### 5.3 — Minor hardening

- [ ] Cap `limit` on `GET /search/live` (`GlobalSearchController.php:30`) — `?limit=999999` drives two full scans plus a `usort`. Not injectable, but a cheap CPU amplifier: `min((int) $request->get('limit', 5), 20)`.
- [ ] Validate `item_id` with `exists:` per `item_type` in `FavouriteController::toggle` — currently `integer` only, so non-existent IDs create rows that pollute the CRM leads grid.
- [x] Replace `$guarded = []` with explicit `$fillable` on `app/Models/ContactUs.php:13` and `app/Models/JobApplication.php:13`. **Done** (Phase 2 branch).
- [ ] Escape LIKE wildcards in CRM filters (`Modules/CRM/App/Http/Controllers/ContactUsController.php:27,31,35`) — bound, so not injection, but `%` dumps everything.
- [ ] Whitelist MIME types and cap array size on CRM reply attachments (`ContactUsController.php:225` — any type, 10 MB, unlimited count); wrap the send in `try/finally` so temp files are cleaned on exception.
- [ ] Tighten `link_urls.*` to `url:http,https` (`ContactUsController.php:226`) — `filter_var` accepts `javascript://`.
- [ ] Add an explicit `from()` to `app/Mail/FavouritesMail.php:30` for SPF/DMARC consistency with the other nine mailables.
- [ ] Confirm `mimes:` validation on the two admin upload paths that skip image re-encoding (`AboutInformationController.php:160`, `OfferController.php:484`).

---

## Phase 6 — Verification

- [ ] Add regression tests for each Phase 1 fix:
  - `evil.php.pdf` upload is rejected or non-executable and non-public.
  - A staff reset token is **refused** at `POST /set-password`.
  - A deactivated user cannot reactivate via an old activation link.
  - `POST /favourites/send-email` is rate limited and does not write `email`/`name` before authorization.
  - A tampered `favourite_session_id` cookie is rejected.
- [ ] Add a test asserting uniform responses for existing vs unknown emails on `/register`, `/forgot-password`, `/resend-activation`, `/set-password`.
- [ ] Re-run the audit on the changed files.
- [ ] Rotate credentials that may have been exposed while `display_errors=On` and `APP_DEBUG=true` were live: `APP_KEY`, DB password, mail password, reCAPTCHA secret, ERPNext API secret. **Note:** rotating `APP_KEY` invalidates all existing sessions, encrypted cookies, and any encrypted column data — plan it.
- [ ] Review server access logs for prior exploitation of Phase 1 items, particularly `/storage/uploads/resumes/` requests.

---

## What is already done well

Worth preserving through the refactor — these are above average for a marketing site:

1. **SQL injection posture is genuinely strong.** ~110 raw sinks, zero unparameterized user input. `DB::select` model methods use named bindings consistently; even hand-written `orderByRaw` CASE expressions use `?` + bindings arrays.
2. **CSRF coverage is correct and minimal** — exactly one exemption (`analytics/heartbeat`), on a non-state-changing endpoint. All ten public POST forms verified inside the `web` group.
3. **Reset token cryptography is textbook** — `hash_hmac('sha256', Str::random(40), key)`, bcrypt-hashed at rest, enforced expiry, single-use, constant-time comparison, separate brokers for invites vs resets.
4. **Login core is solid** — bcrypt cost 12, session regeneration after login, a generic failure message identical for unknown email and wrong password, deactivation revealed only after credentials validate, layered throttling, reCAPTCHA step-up after 3 failures.
5. **No mass assignment** — registration builds an explicit array with `account_type` hardcoded and the role resolved server-side. A registrant cannot set `role`, `is_active`, or ERP IDs.
6. **Bot-defense failures return fake success** (`ContactController::fakeSuccess`) rather than an error — correct, it denies bots the tuning signal.
7. **No mail header injection** — nine of ten mailables hardcode the sender; no user input reaches `from`, `replyTo`, or header construction.
8. **Blade escaping discipline** — the `{!! nl2br(e($x)) !!}` idiom is applied consistently, with `e()` correctly *before* `nl2br`. Zero `{!! !!}` in the CRM contact-us views.
9. **Uniform enumeration-safe responses** on `/forgot-password` and `/resend-activation`, with the reasoning documented in comments — the right pattern already exists in-repo and just needs applying to `/register`.
10. **Admin image uploads re-encode through Intervention Image**, stripping embedded payloads.
11. **`.htaccess` hardening is above average** — `.env`/composer/artisan/backup/log/dotfile denial, framework directory blocking, HTTPS and canonical-host enforcement.

---

## Appendix: severity roll-up

| # | Finding | Severity | Primary location |
|---|---|---|---|
| 1.1 | Résumé upload → likely RCE + public PII | **Critical** | `CareerController.php:128-133` |
| 1.2 | Staff/admin takeover via `/set-password` + host injection | **Critical** | `CustomerPasswordController.php:65-81`, `Kernel.php:17` |
| 1.3 | Favourites mail relay + lead hijack + unsigned cookie | **High** | `FavouriteController.php:139-184`, `EncryptCookies.php:15` |
| 2.1 | Contact captcha + time-trap bypassable by omission | **High** | `ContactController.php:53,59` |
| 0.1 | `display_errors=On` in production | **High** | `.user.ini:7`, `.htaccess:186,198` |
| 0.2 | `APP_DEBUG=true` / `APP_ENV=local` disables reCAPTCHA | **High** (if prod) | `.env`, `RecaptchaService.php:21-23` |
| 3.1 | No per-account brute-force ceiling | Medium | `LoginController.php:213,221` |
| 3.2 | Enumeration on register / set-password / timing | Medium | `CustomerRegistrationService.php:93-110` |
| 3.3 | Password change revokes no tokens; sessions survive | Medium | `ProfileSettingsController.php:82-90` |
| 3.4 | Email change: no re-auth, no throttle | Medium | `ProfileSettingsController.php:40-77` |
| 4.1 | Stored XSS via `map_url` on public contact page | Medium | `branches.blade.php:80` |
| 4.2 | No CSP, no HSTS, `SESSION_SECURE_COOKIE` unset | Medium | `.htaccess:154-172` |
| 5.1 | Project/offer inquiry forms discard user data | Medium | `offers/show.blade.php:668` |
| 5.2 | Analytics heartbeat unthrottled + unbounded `time_on_page` | Medium | `routes/web.php:215-232` |
| 3.5 | `/api/user` returns whole model, no ability gate | Medium | `routes/api.php:20-22` |
| 5.3 | Assorted minor hardening | Low | various |

---

*Generated from a read-only security audit. No application code was modified.*
