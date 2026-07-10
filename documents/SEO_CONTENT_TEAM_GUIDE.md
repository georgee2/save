# SVEC Website — SEO Content Team Guide

> **Purpose:** After a full technical SEO fix of svec.ae (redirects, canonical tags, sitemap, duplicate-URL handling, server errors), the **remaining work is content**. This guide tells the content team exactly what to fill, where, and how — so the site indexes well on Google.

**Last updated:** 2026-07-10

---

## 🎨 Brand Colors & PDF Styling

> **Note for the PDF designer:** When converting this document to PDF, use the official **SVEC brand palette** below. These are the exact colors from the live svec.ae website.

**Core palette**

| Swatch | Color | Hex | Role & where to use in the PDF |
|:---:|---|---|---|
| 🟩 | **Primary — Teal** | `#19868b` | Main headings (H1/H2), the cover/title band, table header rows, links |
| 🟩 | **Secondary — Dark Teal** | `#0d6b6f` | Sub-headings (H3), sidebars, hover/darker shades, footer band |
| 🟥 | **Accent — Red** | `#e1273d` | Call-out boxes, warnings (⚠️), key highlights, action buttons |
| 🟨 | **Accent — Gold** | `#f6b500` | Optional secondary highlight (tips, checklists, badges) |
| 🟦 | **Bright Teal** | `#0ec6d5` | Optional light accent for icons / dividers |

**Neutrals**

| Swatch | Color | Hex | Role |
|:---:|---|---|---|
| ⬛ | **Body text** | `#212529` | Paragraph / table text |
| ⬜ | **Muted text** | `#696969` | Secondary text, captions, notes |
| ⬜ | **Light background** | `#f8f9fa` | Zebra table rows, section backgrounds |
| ⬜ | **Border / divider** | `#eeeeee` | Table borders, rules, separators |
| 🟩 | **Tint background** | `#eff6f7` | Soft teal callout backgrounds (info boxes) |
| ⬜ | **White** | `#ffffff` | Page background, text on colored bands |

**Status colors** (for the ✅ / ⚠️ / ✖ marks in tables)

| Meaning | Hex |
|---|---|
| Success / available ✅ | `#28a745` |
| Warning / partial ⚠️ | `#f6b500` |
| Missing / not available ✖ | `#dc3545` |

**Styling suggestions for the PDF**
- **Cover / title:** teal `#19868b` band, white text, SVEC logo top-left.
- **Headings:** H1 & H2 in teal `#19868b`; H3 in dark teal `#0d6b6f`.
- **Tables:** header row background `#19868b` with white text; alternating row background `#f8f9fa`; borders `#eeeeee`.
- **Call-out / warning boxes (⚠️):** light teal `#eff6f7` background with a red `#e1273d` left border.
- **Body text:** `#212529` on white; keep it clean and readable (11–12pt).
- **Fonts:** a clean sans-serif (e.g. Poppins/Tajawal to match the site, or Arial/Helvetica as a safe fallback).

---

## Table of Contents

1. [What is now automatic — you don't touch this](#1-whats-now-automatic--you-dont-touch-this)
2. [Your job: the SEO fields to fill](#2-your-job-the-seo-fields-to-fill)
3. [How to write good SEO (rules + limits)](#3-how-to-write-good-seo-rules--limits)
4. [Golden rules — don't break SEO](#4-golden-rules--dont-break-seo)
5. [Do-now action list](#5-do-now-action-list)
6. [Known limitations — don't rely on these](#6-known-limitations--dont-rely-on-these)
7. [How to verify your work](#7-how-to-verify-your-work)
8. [Quick reference table](#8-quick-reference-table)
9. [Where to find the SEO fields in admin](#9-where-to-find-the-seo-fields-in-admin)

---

## 1. What's now automatic — you don't touch this

The development team already fixed these at the code level. **You do NOT need to do anything for them** — they work by themselves:

- **Duplicate `/public/` links** → automatically redirected to the clean link.
- **Old / broken links** (e.g. `/offer/SV-OF-C504`, `/our_designs`) → automatically redirected to the right page.
- **Renaming a title changes the URL?** → the system **automatically creates a redirect** from the old link to the new one, so old links never break.
- **Two items with the same title?** → the system **automatically makes the URL unique** (adds `-1`, `-2`).
- **Canonical tags, hreflang (EN/AR), sitemap.xml, robots.txt, https, www** → all handled automatically.
- **Empty category pages** → now correctly return "not found" instead of a server error.

> ✅ **Bottom line:** focus only on writing good content in the SEO fields below. The technical side is done.

---

## 2. Your job: the SEO fields to fill

Every content item has SEO fields in its **Create / Edit** form (usually in a section called **SEO** or **SEO Settings**). Fill them for **both English and Arabic**.

### The four SEO fields

| Field | What it is |
|---|---|
| **SEO Title** | The blue clickable headline in Google results. |
| **SEO Description** | The grey summary text under the title in Google. |
| **SEO Tags / Keywords** | Comma-separated keywords for the page. |
| **Alt Text** (images) | Describes the image — for image search + accessibility. |

> ⚠️ **Important:** if you leave a field empty, the page falls back to the item's **title** (or bio). That still works, but a **unique, well-written description ranks better**. Empty fields are the #1 reason similar pages look "duplicate" to Google.

---

## 3. How to write good SEO (rules + limits)

### SEO Title
- **Length:** ~50–60 characters. Longer gets cut off in Google with "…".
- **Unique per page.** Never reuse the same title on two pages.
- **Formula:** `Main keyword – detail | SVEC`
  - Example: `Luxury 4-Bedroom Villa Design in Sharjah | SVEC`

### SEO Description
- **Length:** ~150–160 characters.
- **Unique + compelling.** Describe what the page offers; invite the click.
- Include the main keyword naturally.
  - Example: `Explore our modern 4-bedroom villa design — 3,200 sq.ft, contemporary style, in Sharjah. View floor plans, gallery and 3D virtual tour.`

### SEO Tags / Keywords
- Comma-separated: `villa design, Sharjah, 4 bedroom, engineering consultancy, SVEC`

### Alt Text
- Short description of the image: `Modern 4-bedroom villa exterior in Sharjah`.
- Do NOT stuff keywords.

### Always fill BOTH languages
If the Arabic SEO fields are empty, the Arabic page may show English text (or fall back to the title). Use the **auto-translate button** if available, then review it before saving.

---

## 4. Golden rules — don't break SEO

| # | Rule |
|---|---|
| 1 | **Don't rename titles without reason.** Renaming changes the URL. The system auto-redirects the old link, but frequent renames still confuse Google. |
| 2 | **You CAN rename safely when needed** — the old link auto-redirects to the new one. No broken links. |
| 3 | **Give each item a unique title.** Avoid two items named exactly the same. |
| 4 | **Check the Publish status.** Unpublished / draft items are invisible to Google. |
| 5 | **Fill English AND Arabic** for every field. |
| 6 | **Write for humans first.** No keyword stuffing — Google penalizes it. |
| 7 | **Add Alt Text to every important image.** Helps image search + accessibility. |

---

## 5. Do-now action list

- [ ] **Projects — fill the few empty ones.** ~3–4 published projects still have empty SEO description/title. Ask the developer to run the "empty SEO fields" report, then fill them.
- [ ] **Static pages (Home, About, Contact, listing pages).** Go to **Admin → SEO Pages** and fill the SEO Title + Description + Tags for each page (Home and About in particular).
- [ ] **Re-check Services & Interior Design items.** A bug that dropped the *SEO Title* and *Alt Text* on these was fixed — if you entered those before and they vanished, re-enter and save.
- [ ] **Add Alt Text** to the main images of offers, projects, and interior items.

---

## 6. Known limitations — don't rely on these

Be aware of these until the developer addresses them:

- **Portfolios, Showcases, and Interior-item detail pages** currently have **no public page** (they show "not found"). Content you add there is **not visible to Google**. Do not promote or link these pages until the developer builds them.
- **Team members** and **Job postings** have **no dedicated SEO fields** — their Google title/description are auto-generated from the bio/description text. Write a clear bio and it will be used.
- **News articles** and **Portfolios** have **no SEO Title and no Alt Text** fields (only SEO Description + Tags exist). The page title comes from the article title.
- **Categories, Subcategories, Partners, Branches, Showcases** have **SEO Description + Tags but no SEO Title** field — the title comes from the category/partner name.

---

## 7. How to verify your work

After you save a page, confirm your SEO is live:

1. Open the public page in the browser.
2. Right-click → **View Page Source** (or press `Ctrl+U`).
3. Press `Ctrl+F` and search for:
   - `name="description"` → should show **your** description, not empty.
   - `og:title` → your title.
   - `rel="canonical"` → the clean page URL (no `/public`).
4. For a quick external check, use Google's **Rich Results Test** (search "Google Rich Results Test") and paste the page URL.

---

## 8. Quick reference table

**Which SEO fields exist for each content type** (✅ = available in admin, ✖ = not available):

| Content type | SEO Title | SEO Description | SEO Tags | Alt Text | Public page? |
|---|:---:|:---:|:---:|:---:|:---:|
| **Offers** | ✅ EN+AR | ✅ EN+AR | ✅ | ✅ EN+AR | ✅ |
| **Projects** | ✅ EN+AR | ✅ EN+AR | ✅ | ✅ EN+AR | ✅ |
| **Services** | ✅ EN+AR | ✅ EN+AR | ✅ | ✖ | ✅ |
| **Interior items** | ✅ EN+AR | ✅ EN+AR | ✅ | ✅ EN+AR | ⚠️ detail page missing |
| **News** | ✖ | ✅ EN+AR | ✅ | ✖ | ✅ |
| **Portfolios** | ✖ | ✅ EN+AR | ✅ | ✖ | ⚠️ page missing |
| **Categories & Subcategories** | ✖ | ✅ EN+AR | ✅ | ✖ | ✅ |
| **Partners & Branches** | ✖ | ✅ EN+AR | ✅ | ✖ | ✅ |
| **Showcases** | ✖ | ✅ EN+AR | ✅ | ✖ | ⚠️ page missing |
| **Team members** | ✖ | ✖ (from bio) | ✖ | ✖ | ✅ |
| **Job postings** | ✖ | ✖ (from description) | ✖ | ✖ | ✅ |
| **Static pages** (Home, About, Contact…) | ✅ via SEO Pages | ✅ via SEO Pages | ✅ via SEO Pages | — | ✅ |

⚠️ = the public page for this type does not exist yet — content is not shown to Google until the developer builds it.

---

## 9. Where to find the SEO fields in admin

- **Offers / Projects / Services / Interior / News / Portfolio:** Admin → the module → **Create** or **Edit** → scroll to the **SEO** section.
- **Categories / Subcategories:** Admin → Basic Data → the category → **Edit** → SEO section.
- **Static pages (Home, About, Contact, listings):** Admin → **SEO Pages** → pick the page → fill Title / Description / Tags.

---

*This guide reflects the SEO fixes completed on 2026-07-10. For technical questions, contact the development team.*
