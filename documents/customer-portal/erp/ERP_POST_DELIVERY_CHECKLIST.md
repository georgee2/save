# ERPNext Integration - Post-Delivery & Activation Checklist (AFTER the ERP team is done)

> Audience: SVEC website team.
> Purpose: turn the ERP team's deliverables into a live, verified integration - safely,
> with a one-line rollback. Run this only after every item in
> [ERP_DEVELOPER_REQUIREMENTS.md](ERP_DEVELOPER_REQUIREMENTS.md) is delivered.

Full technical background: [ERP_INTEGRATION_GUIDE.md](ERP_INTEGRATION_GUIDE.md).

---

## 1. Collect the handover items

- [ ] ERP base URL.
- [ ] Integration API key + API secret (least-privilege user).
- [ ] Shared webhook secret (same value they use to sign).
- [ ] Confirmed field mapping (Customer + Project).
- [ ] Confirmed Project->Customer link field.
- [ ] Default Customer Group + Territory (or confirmation they are optional).
- [ ] How email is exposed (Customer.email_id vs a Contact-based lookup method).
- [ ] Sample payloads (customer created/updated, project, invoice).
- [ ] Doctypes/fields for stages, contract, documents, payments (project-pages phase).
- [ ] Staging ERP details (if provided).

---

## 2. Apply the confirmed field mapping (if different from assumptions)

If any fieldname differs from the assumptions, update the single source of truth:

- `app/Services/ErpNextService.php` -> the `FIELD_MAP` and `DOCTYPE_*` constants.

No other code should need changing. Commit that change on its own so it is easy to review.

---

## 3. Configure environment (staging first)

Set in `.env` (keep the site on staging/maintenance-free; this alone does nothing until `ENABLED=true`):

```
ERPNEXT_ENABLED=true
ERPNEXT_BASE_URL=https://erp.smartvgroup.com
ERPNEXT_API_KEY=xxxxxxxxxxxxxxx
ERPNEXT_API_SECRET=xxxxxxxxxxxxxxx
ERPNEXT_WEBHOOK_SECRET=the-shared-secret
ERPNEXT_TIMEOUT=8
ERPNEXT_CACHE_TTL=300
# Set to valid ERP values if Customer Group / Territory are mandatory on create:
ERPNEXT_DEFAULT_CUSTOMER_GROUP=
ERPNEXT_DEFAULT_TERRITORY=
```

Then refresh cached config:

```
php artisan config:clear
php artisan config:cache
```

---

## 4. Verify the wiring

- [ ] Binding swapped: confirm the container now resolves the real service.

```
php artisan tinker
>>> get_class(app(\App\Services\CustomerSync\CustomerSyncService::class));
# expect: "App\Services\CustomerSync\ErpNextCustomerSyncService"
```

- [ ] Migration applied for the mirror table:

```
php artisan migrate
# creates customer_projects (safe/idempotent - guarded by hasTable)
```

---

## 5. Acceptance tests (staging)

1. **Website register -> ERP customer created + linked**
   - Register a new customer on the site.
   - Expect: a `Customer` appears in ERP; the local user row has `erp_customer_id` + `synced_at` set.

2. **ERP customer created -> website user linked/created (webhook)**
   - Create a Customer in ERP (fires the webhook).
   - Expect: `200 {"status":"created"}` (new email) or `"linked"` (existing email); new users receive a set-password invite.

3. **Webhook rejects tampering**
   - Send a POST with a wrong/missing `X-ERP-Signature`.
   - Expect: `401`. With `ERPNEXT_ENABLED=false`, expect `404`.

4. **Idempotency**
   - Re-send the same webhook with the same `X-ERP-Idempotency-Key`.
   - Expect: `200 {"status":"duplicate_ignored"}`, no duplicate user.

5. **Duplicate-email safety**
   - Register on the website with an email that already exists in ERP.
   - Expect: exactly one user row; it becomes linked (no duplicate).

6. **ERP downtime = graceful**
   - Point `ERPNEXT_BASE_URL` at an unreachable host and register.
   - Expect: registration still succeeds; a warning is logged; no 500 to the user.

Quick signature helper for manual webhook tests. Use whichever header matches how ERP
signs - hex `X-ERP-Signature` (custom Server Script) or base64 `X-Frappe-Webhook-Signature`
(native Frappe Webhook doctype). Both must be computed over the exact `$BODY` bytes.

```bash
BODY='{"erp_customer_id":"CUST-0001","email":"test@example.com","name":"Test","phone":"+9715..."}'

# Option A - custom Server Script (hex)
HEX=$(printf '%s' "$BODY" | openssl dgst -sha256 -hmac "the-shared-secret" | awk '{print $2}')

# Option B - native Frappe webhook (base64)
B64=$(printf '%s' "$BODY" | openssl dgst -sha256 -hmac "the-shared-secret" -binary | openssl base64)

curl -sS -X POST https://STAGING/api/erp/webhook/customer \
  -H "Content-Type: application/json" \
  -H "X-ERP-Signature: $HEX" \
  -H "X-ERP-Idempotency-Key: test-1" \
  -d "$BODY"
# (or swap the header for: -H "X-Frappe-Webhook-Signature: $B64")
```

---

## 6. Go-live (production)

- [ ] Repeat section 3 config on production.
- [ ] `php artisan config:cache` and clear OPcache.
- [ ] Confirm the ERP webhook URL points at the production domain.
- [ ] Smoke test one real registration + one ERP-side customer.
- [ ] Monitor `storage/logs/laravel.log` for `ERPNext ...` warnings for the first day.

---

## 7. Rollback (instant, safe)

If anything misbehaves:

```
# .env
ERPNEXT_ENABLED=false
```
```
php artisan config:cache
```

The app immediately reverts to the no-op sync service and the webhook returns 404.
No data is lost; already-linked `erp_customer_id` values remain and are simply not updated
until re-enabled.
