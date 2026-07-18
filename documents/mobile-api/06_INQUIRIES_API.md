# Inquiries & Contact API

> The app needs (a) a general contact form and (b) "inquire about THIS project/offer".
> The general contact logic exists in [ContactController::store](app/Http/Controllers/ContactController.php).
> Project/offer inquiries need a small backend change because `contact_us` has no
> `project_id` / `offer_id` / `user_id` columns yet (see
> [08_GAPS_AND_BACKEND_CHANGES.md](08_GAPS_AND_BACKEND_CHANGES.md)).

Model: [ContactUs.php](app/Models/ContactUs.php), table `contact_us`.

Current `contact_us` columns: `name`, `subject`, `email`, `phone`, `message`, `service_id`,
`status`, `agent_id`, `notes`. There is NO project/offer/user linkage. The project/offer
"inquiry" forms in the web views are UI stubs (env-gated, no backend action).

---

## 1. General contact - POST `/api/v1/contact`

Reuse [`ContactController::store`](app/Http/Controllers/ContactController.php). It already
handles anti-spam and persistence; adapt it to always return JSON (it already branches on
`wantsJson()`).

Request:

```json
{ "name": "Ahmed", "subject": "Website enquiry", "email": "ahmed@example.com", "phone": "+9715…", "message": "…", "service_id": 3 }
```

Validation (copy verbatim): `name` required ≤255; `subject` required ≤255; `email` required
email ≤255; `phone` nullable ≤255; `message` required ≤5000 + spam-pattern closure (rejects
`[url]`, multiple links, casino/viagra/etc., `<a href`, `{tokens}`); `service_id` nullable
`exists:services,id`; `source` nullable ≤50.

Anti-spam reuse: the web uses honeypot (`website_url`), a time-trap (`_form_loaded`), and
reCAPTCHA v3 (`RecaptchaService`). For the app, DROP honeypot/time-trap (no HTML form) and
instead rely on: the Sanctum token (if logged in) OR an app-attestation/reCAPTCHA token, PLUS
the route `throttle` and the message spam-pattern filter. Keep `RecaptchaService::verify()` if
the app can produce a token; otherwise gate by throttle + auth.

Persistence: `ContactUs::create([... 'status' => 'Pending'])`, then `sendConfirmationEmail()`.

Response:

```json
{ "success": true, "message": "Your message has been sent successfully! We will contact you soon." }
```

Route throttle: match the web's `throttle:5,1` on `contact.store`.

---

## 2. Project / Offer inquiry - POST `/api/v1/inquiries`  (unified)

One endpoint that optionally attaches a `project_id` or `offer_id`, and (if the request is
authenticated) the `user_id`. This is the app's "Enquire about this project/offer" action.

Prerequisite backend change (doc 08): add nullable `project_id`, `offer_id`, `user_id`,
`source` columns to `contact_us` (+ optional relations on `ContactUs`). Until then, inquiries
can only be stored as general messages with the project/offer referenced inside `message`.

Request (logged-in user; `user_id` taken from the token, NOT the body):

```json
{
  "subject": "Interested in Green Tower",
  "message": "Please send more details and pricing.",
  "phone": "+9715…",
  "project_id": 12
}
```

Rules:
- Exactly one of `project_id` / `offer_id` is optional (both may be absent = general inquiry).
- Validate `project_id` `exists:projects,id` and published; `offer_id` `exists:offers,id` and published.
- If authenticated: default `name`/`email` from `$request->user()` (allow override), set `user_id = $request->user()->id`.
- If public (no token): require `name` + `email` like the general contact form, and apply reCAPTCHA/throttle.
- Reuse the same message spam-pattern closure and `throttle` as the contact form.

Persistence:

```php
ContactUs::create([
    'name' => $name, 'email' => $email, 'phone' => $phone,
    'subject' => $subject, 'message' => $message,
    'user_id' => $userId,          // new column
    'project_id' => $projectId,    // new column
    'offer_id' => $offerId,        // new column
    'source' => 'app',             // new column
    'status' => 'Pending',
]);
```

Response:

```json
{ "success": true, "message": "Your inquiry has been sent. Our team will contact you soon." }
```

Then send the confirmation email (`sendConfirmationEmail()`), same as contact.

CRM benefit: with `project_id`/`offer_id`/`user_id` populated, the CRM
(`Modules/CRM/App/Http/Controllers/ContactUsController.php`) and customer pages can show which
listing an inquiry is about and link it to the customer account.

---

## 3. Favourites-by-email vs inquiry

Note there is a separate "email me my favourites" action
([FavouriteController::sendEmail](app/Http/Controllers/FavouriteController.php)); that is a
sharing feature, not an inquiry. Keep them distinct (favourites doc 05).

---

## 4. Summary of what to build

| Endpoint | Reuse | New backend needed |
|----------|-------|--------------------|
| `POST /api/v1/contact` | `ContactController::store` logic + validation | none (JSON-only adaptation) |
| `POST /api/v1/inquiries` | same anti-spam/persistence pattern | `contact_us` add `project_id`, `offer_id`, `user_id`, `source` (doc 08) |
