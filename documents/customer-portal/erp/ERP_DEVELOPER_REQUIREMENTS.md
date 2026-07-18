# ERPNext Integration - Requirements for the ERP Team (BEFORE work starts)

> Audience: ERPNext developers/administrators.
> Purpose: everything the SmartVision (SVEC) website needs from the ERP side so the
> already-built (but disabled) website integration can be switched on without changes.
> Status: the website side is implemented and inert (`ERPNEXT_ENABLED=false`). Nothing
> below affects the live site until we flip the flag after you deliver these items.

Related docs: [ERP_POST_DELIVERY_CHECKLIST.md](ERP_POST_DELIVERY_CHECKLIST.md) (after you finish) and [ERP_INTEGRATION_GUIDE.md](ERP_INTEGRATION_GUIDE.md) (full technical guide).

---

## 1. What we are building (context)

- One person = one account across the website, the mobile app, and ERPNext.
- The **website owns the login password** (set by the customer via an emailed link). ERP never stores or sends plaintext passwords.
- Reconciliation key between systems = **normalized email** (lowercased, trimmed) plus the ERP customer id.
- Direction of data:
  - **ERP -> Website:** when a Customer is created/updated in ERP, notify the website (webhook) so it creates/links the matching user.
  - **Website -> ERP:** when someone registers or edits their profile on the website, the website calls ERP to find-or-create/update the Customer.

---

## 2. Deliverables checklist (what we need from you)

1. [ ] ERP base URL: `https://erp.smartvgroup.com` (confirm reachable + HTTPS valid).
2. [ ] API key + API secret for a **dedicated integration user** with least-privilege roles (see section 3).
3. [ ] A shared **webhook secret** (random string) used to sign outbound webhooks (see section 5).
4. [ ] Confirmation/correction of the **field mapping** (section 4).
5. [ ] An **outbound webhook** on Customer create/update -> POST to our endpoint (section 5; native Webhook doctype preferred).
6. [ ] Valid **default Customer Group + Territory** values for website-created customers (section 6), or confirmation they are optional.
7. [ ] Sample JSON payloads for: a created customer, an updated customer, a project, and an invoice.
8. [ ] Confirmation of the **project / invoice / file** doctypes and fields (sections 6-7) for the later project-pages phase.

---

## 3. API access + permissions

- Auth method: **Frappe token auth**. We send the header on every request:

```
Authorization: token <api_key>:<api_secret>
Accept: application/json
```

- The integration user needs least-privilege access to these doctypes:
  - `Customer` - read + write (find-or-create, update).
  - `Project` - read (list + detail).
  - `Sales Invoice` and/or `Payment Entry` - read (payments in the project-pages phase).
  - `File` - read (secure document download, proxied by the website).

Please avoid granting System Manager. A custom role scoped to the doctypes above is preferred.

---

## 4. Field mapping (confirm or correct)

The website keeps all ERP field names in ONE place: the `FIELD_MAP` constant in
`app/Services/ErpNextService.php`. If your fieldnames differ, just tell us the correct
ones and we update that map - no other code changes.

Current assumptions:

| Website meaning        | Assumed ERPNext field (Customer) | Confirm / correct |
|------------------------|----------------------------------|-------------------|
| Customer email         | `email_id` (from primary Contact)|                   |
| Customer full name     | `customer_name`                  |                   |
| Customer phone         | `mobile_no` (from primary Contact)|                  |
| Customer id (returned) | `name` (ERP docname)             |                   |

> `email_id` and `mobile_no` are ReadOnly on Customer, mirrored from the primary Contact.
> Confirm whether your setup reliably populates them; if email lives only on Contact,
> please provide a whitelisted method to look up a Customer by email (section 6).

| Website meaning        | Assumed ERPNext field (Project)  | Confirm / correct |
|------------------------|----------------------------------|-------------------|
| Project id             | `name` (ERP docname)             |                   |
| Project title          | `project_name`                   |                   |
| Project status         | `status`                         |                   |
| Progress percent       | `percent_complete`               |                   |
| Linked customer        | `customer`                       |                   |
| Contract reference     | `custom_contract_ref`            |                   |

> If a customer link on Project is not the standard `customer` field, tell us which field joins a Project to a Customer.

---

## 5. Outbound webhook: Customer created/updated (ERP -> Website)

Fires on Customer **after insert** and **after update**, POSTing to our endpoint. Our
receiver accepts **either** of two signing styles, so pick whichever is easier.

- Method: `POST`
- URL: `https://<WEBSITE_DOMAIN>/api/erp/webhook/customer`

### 5.1 Option A (RECOMMENDED) - native Frappe Webhook doctype, no code

Use **Integrations > Webhook**:

1. DocType: `Customer`; Doc Events: `after_insert` and `on_update`.
2. Request URL: `https://<WEBSITE_DOMAIN>/api/erp/webhook/customer`
3. Request Structure: **JSON**.
4. Enable **Webhook Secret** and paste the shared secret. Frappe then adds the
   `X-Frappe-Webhook-Signature` header automatically (base64-encoded HMAC-SHA256 of
   the JSON body) - our endpoint verifies this natively. No Server Script needed.
5. Webhook Data (Fieldname -> Key) - map ERP fields to the exact keys we expect:

   | ERP Fieldname        | Key (must be exactly) |
   |----------------------|-----------------------|
   | `name`               | `erp_customer_id`     |
   | `email_id`           | `email`               |
   | `customer_name`      | `name`                |
   | `mobile_no`          | `phone`               |

6. Optionally add a static header `X-ERP-Idempotency-Key` (or we fall back to the
   payload) so retries are de-duplicated.

> Caveat: `email_id`/`mobile_no` on Customer are populated from the **primary Contact**.
> If a customer has no primary contact, `email` may be empty. Either ensure a primary
> contact exists, or add a webhook **Condition** so we only receive customers that have
> an email. Without an email we can store the ERP id but cannot send an activation invite.

### 5.2 Option B (alternative) - custom Server Script, hex signature

If you prefer a Server Script, send header `X-ERP-Signature` = **hex** HMAC-SHA256 of the
exact raw body:

```python
import hmac, hashlib, json, requests

secret = "THE_SHARED_WEBHOOK_SECRET"
body = json.dumps({
    "erp_customer_id": doc.name,
    "email": (doc.email_id or "").strip().lower(),
    "name": doc.customer_name,
    "phone": doc.mobile_no,
}, separators=(",", ":"))

signature = hmac.new(secret.encode(), body.encode(), hashlib.sha256).hexdigest()

requests.post(
    "https://WEBSITE_DOMAIN/api/erp/webhook/customer",
    data=body,
    headers={
        "Content-Type": "application/json",
        "X-ERP-Signature": signature,
        "X-ERP-Idempotency-Key": doc.name + "|" + str(doc.modified),
    },
    timeout=10,
)
```

> Important (both options): the signature must be computed over the **exact bytes** sent
> as the body. If the HTTP client re-serializes the JSON after signing, the signature will
> not match and we return 401.

### 5.3 Body shape (both options)

```json
{
  "erp_customer_id": "CUST-0001",
  "email": "customer@example.com",
  "name": "Jane Customer",
  "phone": "+9715xxxxxxxx"
}
```

### 5.4 What the website does on receipt

- Verifies the signature (rejects with 401 if invalid; 404 while integration disabled).
- Finds a user by `erp_customer_id`, else by `email`.
- If found -> links (stores `erp_customer_id`, keeps the existing password, ensures the customer role).
- If not found -> creates a customer account (no password) and emails a set-password invite (only if an email is present).
- Returns `200 {"success": true, "status": "linked|created|duplicate_ignored"}`.

---

## 6. Read endpoints we will call (Website -> ERP)

Standard Frappe REST is fine; no custom endpoints required unless noted.

- **Find customer by email:**
  `GET /api/resource/Customer?filters=[["email_id","=","<email>"]]&limit_page_length=1`
- **Create customer:**
  `POST /api/resource/Customer` with `{ customer_name, email_id, mobile_no, customer_type: "Individual" }`.
  ERPNext usually requires `customer_group` and `territory` too - tell us the valid
  default values to send (we set `ERPNEXT_DEFAULT_CUSTOMER_GROUP` / `ERPNEXT_DEFAULT_TERRITORY`),
  or confirm they are optional in your setup.
- **Update customer:**
  `PUT /api/resource/Customer/<name>` with changed fields.
- **List projects by customer:**
  `GET /api/resource/Project?filters=[["customer","=","<CUST-ID>"]]&fields=["name","project_name","status","percent_complete"]`
- **Project detail:**
  `GET /api/resource/Project/<name>`

If any of these must be a custom whitelisted method instead of raw resource access, please provide the method path + expected params.

---

## 7. Project detail data (for the later project-pages phase)

For each project the website will eventually display: **stages/tasks with status**, **contract**, **documents**, and **payments**. Please confirm how to retrieve:

- Stages/tasks: doctype + fields (name, status, progress, dates) and how they link to a Project (e.g. `Task.project`).
- Contract: field on Project or a related doctype + the `File` reference for download.
- Documents: how project files are attached (the `File` doctype filtered by `attached_to_doctype`/`attached_to_name`).
- Payments/invoices: `Sales Invoice` (amount, due date, status, outstanding) and/or `Payment Entry`, filtered by customer/project.

> Document downloads will be **proxied** by the website (we never expose ERP URLs or credentials to the browser).

---

## 8. Non-functional expectations

- Reasonable response times; the website uses an 8s timeout and short-lived caching, and **fails open** (shows cached/empty rather than erroring) if ERP is slow/unavailable.
- The integration user's credentials should be rotatable; tell us the process.
- A test/staging ERP instance (or test records) for end-to-end verification before go-live is strongly preferred.

---

## 9. Open questions for you to answer

1. Exact fieldnames where our assumptions in section 4 are wrong.
2. The Project->Customer link field name.
3. Doctypes/fields for stages, contract, documents, payments (section 7).
4. Preferred idempotency key format for the webhook.
5. Staging environment availability + credentials rotation process.
6. Default Customer Group + Territory to use on create (or confirm optional).
7. Whether email is reliably on Customer.email_id, or if a Contact-based lookup method is needed.
