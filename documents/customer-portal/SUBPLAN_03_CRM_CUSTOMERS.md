# Sub-Plan 03: CRM Dashboard + Customers List (Internal)

> Derived from [CUSTOMER_PORTAL_MASTER_PLAN.md](CUSTOMER_PORTAL_MASTER_PLAN.md) (7.7, 7.8).
> Scope ships WITHOUT ERPNext. ERP-linked fields (erp_customer_id, sync status) are shown as
> "not linked" placeholders until the ERP sub-plan lands; project counts are placeholders too.

---

## 1. Scope

**In scope (build now):**
1. Turn the empty CRM dashboard into a real KPI dashboard (7.7).
2. A registered-customers management screen mirroring the Favourites pattern (7.8): list + filters + live search + show + assign/unassign agent + internal comments + send-email (with logging) + export.

**Out of scope (later sub-plans):**
- ERP sync/webhook (master 7.6), project pages (7.9).
- `sendNotification` (project-update email) - deferred until project data exists.

Customers already exist as `users` where `account_type = 'customer'`; the `customers` / `crm-dashboard`
permission modules are already seeded (Sub-Plan 01). This sub-plan is mostly screens over existing data,
mirroring [Modules/CRM/App/Http/Controllers/FavouritesController.php](../../Modules/CRM/App/Http/Controllers/FavouritesController.php).

---

## 2. Confirmed decisions
- Agent link stored as a `users.assigned_agent_id` column (mirrors Favourites' `sales_agent_id`).
- Internal comments table included (`customer_comments`).
- Customer emails CC the assigned agent (like Favourites).

---

## 3. Data model (additive migrations)

- `users.assigned_agent_id` nullable, FK `agents` nullOnDelete. Add to `$fillable` + `assignedAgent()` relation in [app/Models/User.php](../../app/Models/User.php).
- `customer_email_logs`: `id`, `customer_id` (FK users cascade), `sent_by` (FK users nullOnDelete), `to_email`, `cc_email` nullable, `subject`, `body` text nullable, `attachments` json nullable, `type` enum(`direct`,`notification`) default `direct`, timestamps. Mirror [create_favourite_email_logs_table](../../database/migrations/2026_03_22_000003_create_favourite_email_logs_table.php).
- `customer_comments`: `id`, `customer_id` (FK users cascade), `author_id` (FK users nullOnDelete), `comment` text, timestamps. Mirror [create_favourite_comments_table](../../database/migrations/2026_03_22_000002_create_favourite_comments_table.php).

---

## 4. Backend

- Models `App\Models\CustomerEmailLog` (customer + sender relations), `App\Models\CustomerComment` (customer + author relations).
- Mailable `App\Mail\CustomerDirectMail` mirroring `App\Mail\FavouritesDirectMail`, view `emails.customer-direct` extending `emails.layouts.master`.
- `Modules\CRM\App\Http\Controllers\CustomersController`: `index`, `liveSearch`, `show`, `assignAgent`, `unassignAgent`, `storeComment`, `deleteComment`, `sendEmail` (afterResponse dispatch), `exportReport`.
- `App\Exports\CustomersReportExport` mirroring `FavouritesReportExport`.
- Dashboard: replace `CRMController@index` stub with KPIs + recent customers + registrations chart.

Customer source: `User::customers()->whereNull('deleted_at')` left-joined to `agents` for the assigned-agent name. Status filter: `activated` = `password_set_at` not null, `pending` = null.

---

## 5. Routes (Modules/CRM/routes/web.php, inside the auth+staff crm group)

`crm/customers` block, names `crm-customers.*`: `index`, `export-report`, `live-search`, `show/{id}`,
`assign-agent/{id}`, `unassign-agent/{id}`, `send-email/{id}`, `comment/{id}`, `comment-delete/{id}`.

---

## 6. Permissions (map only; modules already seeded)

Add to `$routePermissions` in [app/Http/Middleware/CheckRoutePermission.php](../../app/Http/Middleware/CheckRoutePermission.php):
- `CRM => crm-dashboard-view`
- `crm-customers.index|show|live-search|export-report => customers-view`
- `crm-customers.assign-agent|unassign-agent|store-comment|delete-comment => customers-edit`
- `crm-customers.send-email => customers-send_email`

Super-admin bypasses; other staff roles need these granted via the Roles UI.

---

## 7. Views

- `Modules/CRM/resources/views/customers/index.blade.php` and `.../customers/show.blade.php` (mirror favourites index/show).
- `Modules/CRM/resources/views/index.blade.php` dashboard (KPI cards + chart + recent customers).
- Add a "Customers" link to the CRM sidebar [Modules/CRM/resources/views/includes/side.blade.php](../../Modules/CRM/resources/views/includes/side.blade.php).

---

## 8. Acceptance criteria
- Dashboard shows live counts + chart, gated by `crm-dashboard-view`.
- List shows only `account_type=customer`, non-deleted; filters + live search + pagination + export work.
- Assign/unassign agent, comments, and send-email persist; emails log to `customer_email_logs` and CC the assigned agent.
- Every action is permission-gated; staff/customer isolation intact.

---

## 9. Execution checklist
1. Migrations (assigned_agent_id, customer_email_logs, customer_comments).
2. Models + User relation + CustomerDirectMail + email view.
3. CustomersController + CustomersReportExport.
4. Routes + permission-map entries.
5. Dashboard controller + view.
6. Customers index/show views + sidebar link.
7. migrate, optimize:clear, grant permissions to a role, smoke-test.

---

## 10. Follow-up phases (post-implementation gaps)

> Core scope (sections 1-9) is implemented and smoke-tested. The phases below track
> remaining gaps found during review, ordered by priority. Each can ship independently.

### Phase 1 - Agent reference integrity (HIGH)
Problem: `users.assigned_agent_id` has **no foreign key** because the `agents` table is MyISAM
(can't hold FKs), so it was built as a plain indexed column mirroring `favourites.sales_agent_id`.
Deleting an agent leaves stale `assigned_agent_id` values (no `ON DELETE SET NULL`).
- Option A (preferred): convert `agents` (and dependent tables) to InnoDB, then add the real
  FK `nullOnDelete` in a follow-up migration.
- Option B: on agent delete (`AgentController@destroy`), null out `users.assigned_agent_id`
  (and `favourites.sales_agent_id`) for that agent.
- Acceptance: deleting an agent never leaves a dangling reference; list/show render cleanly.

### Phase 2 - Email log accuracy vs async send (HIGH)
Problem: `sendEmail()` dispatches the mail via `->afterResponse()` and writes the
`customer_email_logs` row immediately, so a later SMTP failure is still logged as "sent".
- Move the log write inside the dispatched closure after a successful `Mail::send()`, or wrap
  the send in try/catch and record a `failed`/`sent` status.
- Consider adding a `status` column (`queued`,`sent`,`failed`) to `customer_email_logs`.
- Acceptance: the log reflects real send outcome; failures are visible.

### Phase 3 - Dashboard permission rollout (HIGH - operational)
Problem: adding `'CRM' => 'crm-dashboard-view'` gates a route that was previously open to all
staff; non-super-admin roles without the permission now get redirected.
- Before deploy, grant `crm-dashboard-view` + `customers-*` to the appropriate staff roles via
  the Roles UI (or a seeder update).
- Acceptance: intended staff roles reach the CRM dashboard and customers screens; others are
  correctly denied.

### Phase 4 - Deferred ERP / project features (MEDIUM - depends on ERP sub-plan)
Currently placeholders; wire up when ERP/projects land:
- `sendNotification` (project-update email) in `CustomersController` (master 7.8 step 1).
- ERP-sync-status filter on the index (replace/augment the `verified` filter).
- Real project count + project summary on the show page (master 7.9).
- Acceptance: ERP link/sync status and project data show live values, not placeholders.

### Phase 5 - Customer create/delete permissions (MEDIUM)
Problem: seeded `customers-create` / `customers-delete` are unused (no CRM create/delete flow;
customers arrive via registration/ERP).
- Decide: either add guarded create/delete actions (+ routes + map entries + UI), or remove the
  unused permissions from the seeder to avoid confusion.
- Acceptance: every seeded `customers-*` permission maps to a real, gated action.

### Phase 6 - Activity logging on new models (MEDIUM)
Problem: `CustomerComment` and `CustomerEmailLog` don't use the `LogsActivity` trait (master P7).
- Add `LogsActivity` (with a sensible title field) to both models; verify entries appear in
  activity logs for create/delete.
- Acceptance: comment add/delete and email sends are audit-logged.

### Phase 7 - Feature tests (MEDIUM - master 11 / P7)
No automated tests exist for this sub-plan. Add coverage for:
- index/show/liveSearch/export, assign/unassign, comment store/delete, sendEmail (+ log + CC).
- Access isolation: a customer or a staff member without `customers-*` is blocked.
- Acceptance: tests pass in CI and cover the acceptance criteria in section 8.

### Phase 8 - Minor hardening (LOW)
- Respect customer consent / `notification_prefs` before sending a direct email.
- Paginate the show-page email log and comment thread (they grow unbounded).
- Ensure orphaned temp attachments in `storage/app/temp_email_attachments` are cleaned even when
  a send throws (mirror the favourites limitation, or clean via a scheduled task).
- Acceptance: no unbounded lists, no opt-out violations, no leftover temp files.
