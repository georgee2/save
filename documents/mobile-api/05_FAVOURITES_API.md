# Favourites API

> TOKEN-GATED (`auth:sanctum`). Reuse the logic in
> [FavouriteController.php](app/Http/Controllers/FavouriteController.php), but change the
> IDENTITY: the web keys favourites by a cookie/session id; the app must key by `user_id` so
> favourites sync across devices and survive re-login.

Model: [Favourite.php](app/Models/Favourite.php), table `favourites`.

---

## 1. The key decision: identity

Today (web): `Favourite::getSessionId()` returns a cookie `favourite_session_id` (30-day) or a
session UUID, and every query is scoped `->forSession($sessionId)`. This is fine for anonymous
web visitors but wrong for a logged-in app user (a token has no cookie/session).

For the app: scope favourites by `user_id`. This requires a small backend change - add a
nullable `user_id` column + a `forUser()` scope (documented in
[08_GAPS_AND_BACKEND_CHANGES.md](08_GAPS_AND_BACKEND_CHANGES.md)). The endpoint logic below is
otherwise a direct copy of the web controller with `->forSession($sessionId)` replaced by
`->where('user_id', $request->user()->id)`.

Columns available to reuse: `item_type` (`project|offer|interior`), `item_id`, `emirate_id`,
`price`, `expires_at`. Unique constraint is `(session_id, item_type, item_id)`; when adding
`user_id`, add a matching unique index `(user_id, item_type, item_id)`.

---

## 2. Endpoints (mirror FavouriteController)

### GET `/api/v1/favourites`  ·  `ability:customer:read`
Mirror [`FavouriteController::index`](app/Http/Controllers/FavouriteController.php) +
`groupFavourites()`, but return JSON instead of a view. It resolves each favourite to its
`Project` / `Offer` / `InteriorDesignGallery` and, for offers with a saved `emirate_id`, the
selected price.

```json
{
  "success": true,
  "data": {
    "projects": [ { "favourite_id": 10, "item_id": 12, "project": { "id": 12, "slug": "green-tower", "title": "Green Tower", "main_image": "https://…" } } ],
    "offers":   [ { "favourite_id": 11, "item_id": 7, "emirate_id": 1, "selected_price": { "emirate": "Dubai", "price": 250000 }, "offer": { "id": 7, "slug": "villa-package", "title": "Villa Package", "main_image": "https://…" } } ],
    "interiors":[ { "favourite_id": 12, "item_id": 4, "interior": { "id": 4, "slug": "modern-living", "title": "Modern Living", "image": "https://…" } } ]
  },
  "meta": { "total": 3 }
}
```

Reuse `groupFavourites()`'s eager-loads: projects `['category','subcategory','emirate','specifications']`; offers `['category','subcategory','prices'(status=0),'prices.emirate','currency','specifications']`; interiors `['category','projectStyle']`.

### GET `/api/v1/favourites/count`  ·  `ability:customer:read`
Mirror [`FavouriteController::count`](app/Http/Controllers/FavouriteController.php). Returns the count and an id list the app uses to render "favourited" states on cards:

```json
{ "count": 3, "items": ["project_12", "offer_7", "interior_4"] }
```

### POST `/api/v1/favourites/toggle`  ·  `ability:customer:write`
Mirror [`FavouriteController::toggle`](app/Http/Controllers/FavouriteController.php). Same
validation; add/remove for the current user.

Request:

```json
{ "item_type": "offer", "item_id": 7, "emirate_id": 1, "price": 250000 }
```

Validation (identical to web): `item_type` in `project,offer,interior`; `item_id` required integer; `emirate_id` nullable integer; `price` nullable numeric. On create it sets `expires_at = now()+30 days` (for app/user favourites you may set `is_permanent = true` / null expiry - see gaps doc).

Response:

```json
{ "success": true, "added": true, "count": 4 }
```

### DELETE `/api/v1/favourites/{id}`  ·  `ability:customer:write`
Mirror [`FavouriteController::remove`](app/Http/Controllers/FavouriteController.php) with
`->where('user_id', ...)->findOrFail($id)`. Response `{ "success": true, "count": 3 }`.

### DELETE `/api/v1/favourites`  ·  `ability:customer:write`
Mirror [`FavouriteController::clear`](app/Http/Controllers/FavouriteController.php). Deletes
all favourites for the user. Response `{ "success": true, "count": 0 }`.

---

## 3. Optional: share-by-email

The web `sendEmail` / `shared` (share a favourites list by email/link) is not core to the app
MVP. If wanted, reuse [`FavouriteController::sendEmail`](app/Http/Controllers/FavouriteController.php)
(+ `FavouritesMail`) verbatim behind the token; the share link would use the user's id/token
instead of a session id.

---

## 4. Migration note (one-time, anonymous -> account)

If the app previously let a user favourite while anonymous (unlikely, since browse-only needs
no favourites), you could merge a device session id into `user_id` on login. Not required for
MVP; documented as optional in [08_GAPS_AND_BACKEND_CHANGES.md](08_GAPS_AND_BACKEND_CHANGES.md).
