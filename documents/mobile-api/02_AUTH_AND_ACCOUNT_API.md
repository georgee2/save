# Auth & Account API

> The auth core already exists and is shared with the website through
> [CustomerRegistrationService](app/Services/CustomerRegistrationService.php). Document the
> existing endpoints EXACTLY as they behave, then build 3 parity endpoints
> (forgot / reset / resend-activation) by reusing the web brokers and controllers.
>
> Flow: register -> customer receives an INVITE email -> sets password via a signed link ->
> logs in to receive a Sanctum token. There is no password in the register request.

Existing routes: [routes/api.php](routes/api.php), `customer` prefix.

---

## A. EXISTING endpoints (already built - document, don't rebuild)

### POST `/api/customer/register`  ·  throttle `5,1` + per-email `5/hour`

Source: [CustomerAuthController::register](app/Http/Controllers/Api/CustomerAuthController.php) -> [CustomerRegistrationService::register](app/Services/CustomerRegistrationService.php).

Request:

```json
{ "name": "Ahmed", "email": "ahmed@example.com", "phone": "+9715...", "consent": true, "preferred_locale": "en" }
```

Validation: `name` required; `email` required + `email:rfc,dns` + [DisposableEmail](app/Rules/DisposableEmail.php); `phone` nullable ≤30; `consent` must be `accepted` (truthy); `preferred_locale` in `en,ar`.

Success (always the same message, even for an existing address? NO - see note):

```json
{ "success": true, "message": "Account created. Check your email to set your password and activate your account." }
```

Behavior notes:
- If the email already exists, the service throws a 422 with a specific message: `account_email_pending` (created but never activated) or `account_email_registered` (already active), or "already in use" for non-customer accounts. The app should surface these to guide the user to log in / reset / check email.
- On success an invite email is sent via the `invitations` broker (48h token) after the response is flushed. Per-email cooldown = 1 invite / 10 min.
- New user: `account_type=customer`, `is_active=true`, role `website-user`, unusable random password until they set one.

#### One account across app, website, and ERP (IMPORTANT)

App registration is NOT a separate user store. Both the app API and the website call the SAME
[CustomerRegistrationService::register()](app/Services/CustomerRegistrationService.php), so an
account created in the app immediately works on the website and vice versa (one `users` row per
email; email is unique and lower-cased). The only difference is the `source` column: the API
passes `'app'`, the website passes `'web'` - useful for analytics, not for isolation.

The service also fires the ERP hook on every successful registration:

```php
// inside CustomerRegistrationService::register()
$this->sync->onCustomerRegistered($user);   // CustomerSyncService
```

- `CustomerSyncService` is bound in [AppServiceProvider](app/Providers/AppServiceProvider.php)
  to `ErpNextCustomerSyncService` when ERP is enabled+configured, else to a no-op
  `NullCustomerSyncService`. So today (ERP disabled) registration is fully internal; when ERP
  is switched on, the SAME app registration will create/link the ERPNext Customer - no app or
  API change required.
- The hook is best-effort and wrapped in try/catch: an ERP outage NEVER fails or slows the
  app's registration response (this is the "no errors for users from integration" rule).
- Reverse direction: a Customer created in ERPNext flows back via the inbound webhook
  ([ErpWebhookController](app/Http/Controllers/Api/ErpWebhookController.php)), which creates or
  links a website `users` row and emails an invite - so that person can then log in from the
  app with the same credentials. See the ERP docs in `documents/customer-portal/erp/`.

Net: the app team does not implement any ERP logic. They just call the existing register
endpoint; identity stays unified across app ↔ website ↔ ERP automatically.

### POST `/api/customer/login`  ·  throttle `10,1` + per-email `5/min`

Source: [CustomerAuthController::login](app/Http/Controllers/Api/CustomerAuthController.php).

Request:

```json
{ "email": "ahmed@example.com", "password": "Secret123", "device_name": "iPhone 15" }
```

Success:

```json
{
  "success": true,
  "token": "12|plainTextTokenValue...",
  "user": { "id": 5, "name": "Ahmed", "email": "ahmed@example.com", "phone": "+9715..." }
}
```

Rules: rejects non-customer accounts ("This account cannot access the customer app.") and inactive accounts ("This account is inactive."); wrong credentials -> generic "The provided credentials are incorrect." Token abilities: `customer:read`, `customer:write`. Store `token` securely on device; send as `Authorization: Bearer`.

### POST `/api/customer/logout`  ·  auth `customer:read`

Revokes the current token only. Response: `{ "success": true }`.

### GET `/api/customer/me`  ·  auth `customer:read`

```json
{ "id": 5, "name": "Ahmed", "email": "ahmed@example.com", "phone": "+9715...", "preferred_locale": "en" }
```

### GET `/api/customer/profile`  ·  auth `customer:read`

Source: [CustomerProfileController::show](app/Http/Controllers/Api/CustomerProfileController.php).

```json
{
  "id": 5, "name": "Ahmed", "email": "ahmed@example.com",
  "pending_email": null, "phone": "+9715...", "preferred_locale": "en",
  "notification_prefs": { "email_updates": true }, "email_verified": true
}
```

### PUT `/api/customer/profile`  ·  auth `customer:write`

Source: [CustomerProfileController::update](app/Http/Controllers/Api/CustomerProfileController.php). All fields `sometimes`.

```json
{ "name": "Ahmed A.", "phone": "+9715...", "email": "new@example.com", "preferred_locale": "ar", "notification_prefs": { "email_updates": false } }
```

Response: `{ "success": true, "email_change_pending": true }`.

Email-change flow (IMPORTANT): a new email is NOT applied immediately. It is stored in `pending_email` and a signed verification link (`account.email.verify`, 24h) is emailed to the NEW address. The user must click it - which is a WEB route today. The app has no in-app confirmation screen yet (flagged in [08_GAPS_AND_BACKEND_CHANGES.md](08_GAPS_AND_BACKEND_CHANGES.md)). `email` unique against both `users.email` and `users.pending_email`.

### PUT `/api/customer/password`  ·  auth `customer:write`

Source: [CustomerProfileController::updatePassword](app/Http/Controllers/Api/CustomerProfileController.php).

```json
{ "current_password": "OldPass1", "password": "NewPass1", "password_confirmation": "NewPass1" }
```

Rules: `current_password:sanctum`; new password `confirmed`, ASCII-only (`regex:/^[\x20-\x7E]+$/`, no Arabic), and `Password::defaults()` (min 8, mixed case, numbers). Response `{ "success": true }`.

---

## B. TO BUILD - app parity endpoints

Put these under `/api/v1/auth/*`. Reuse the web brokers/controllers so behavior matches the site.

### POST `/api/v1/auth/forgot-password`

Reuse: [CustomerForgotPasswordController::sendResetLink](app/Http/Controllers/Auth/CustomerForgotPasswordController.php). It already: validates `email:rfc,dns` + `DisposableEmail`, applies a 10-min per-email cooldown, and returns a UNIFORM response regardless of whether the email exists (anti-enumeration).

Request: `{ "email": "ahmed@example.com" }`

Response (always): `{ "success": true, "message": "If that email exists, a reset link has been sent." }`

Spec notes for the API build:
- Skip the web honeypot/time-trap fields; instead apply the route `throttle` + the existing per-email cooldown.
- The reset link points to a WEB page today. For a fully native reset, either (a) let the app open the web reset page in an in-app browser, or (b) build the reset endpoint below and send the app a deep link containing the token. Decide with the app team; option (b) is documented next.

### POST `/api/v1/auth/reset-password`

Reuse: [CustomerPasswordController](app/Http/Controllers/Auth/CustomerPasswordController.php) (default `password_reset_tokens` broker) - same broker the web uses, so tokens are interchangeable.

Request:

```json
{ "email": "ahmed@example.com", "token": "<reset-token>", "password": "NewPass1", "password_confirmation": "NewPass1" }
```

Logic: call `Password::broker()->reset(...)`, set `password = Hash::make(...)` + `password_set_at = now()`. Apply the SAME password rules as `updatePassword` (ASCII-only + `Password::defaults()`). On success `{ "success": true }`; invalid/expired token -> 422 with a generic message. Do NOT auto-login (mirror web); the app should send the user to login.

### POST `/api/v1/auth/resend-activation`

Reuse: [CustomerRegisterController::resendActivation](app/Http/Controllers/Auth/CustomerRegisterController.php) + `CustomerRegistrationService::sendInvite($user)`.

Request: `{ "email": "ahmed@example.com" }`

Logic: look up the customer; if it exists and is NOT yet activated (`password_set_at IS NULL`), call `sendInvite()` (48h `invitations` broker token, 10-min cooldown). Return a UNIFORM response either way.

Response (always): `{ "success": true, "message": "If that account needs activation, we've sent a new link." }`

---

## C. Abilities & middleware summary

| Endpoint group | Middleware |
|----------------|-----------|
| register / login / forgot / reset / resend | route `throttle` only (public) |
| me / logout / profile (GET) / favourites GET | `auth:sanctum` + `ability:customer:read` |
| profile (PUT) / password / favourites write / inquiries | `auth:sanctum` + `ability:customer:write` |

## D. Password rules (single source of truth)

`Password::defaults()` is set in [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php) to min 8 + mixed case + numbers. All password-setting endpoints additionally enforce ASCII-only via `regex:/^[\x20-\x7E]+$/` with message `lang.account_password_english_only`. Keep this identical across register-activation, reset, and change so the app can validate client-side once.
