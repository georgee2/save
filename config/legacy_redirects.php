<?php

/*
|--------------------------------------------------------------------------
| Legacy URL redirect patterns
|--------------------------------------------------------------------------
|
| Maps old-website URL families to the nearest current listing. Keys are
| regex patterns tested against the request path AFTER the leading locale
| segment (en/ ar/) has been stripped. Values are the target listing path
| (the locale is injected at runtime by the LegacyRedirect middleware).
|
| These recover the bulk of the "Not found (404)" URLs reported in Google
| Search Console when no exact old->new mapping is available. Exact 1:1
| redirects (if a legacy export is imported later) live in the
| `url_redirects` table and take precedence over these patterns.
|
| Delimiter is '#', flags are case-insensitive ('i').
|
| ORDER MATTERS: the first matching pattern wins, so specific rules are listed
| before the general multi-segment /category/ catch-all. The current real
| /category/{slug} route is always single-segment, so any /category/a/b... path
| is legacy and safe to redirect.
|
*/

return [
    // Old interior-design category paths (multi-segment) -> interior-design gallery
    // e.g. /category/interior_design/interior_site_projects, /category/interior_design/villa/maid_room
    '#^category/interior[_-]?design(/|$)#i' => 'interior-design',

    // /our_designs?category=...                          -> interior-design gallery
    '#^our_designs#i' => 'interior-design',

    // /offer/SV-OF-C504, /offer/SV-OF-P408 ...          -> offers listing
    '#^offer/.+#i' => 'offers',

    // /category/{cat}/project/{slug}                     -> projects listing
    '#^category/[^/]+/project/.+#i' => 'projects',

    // /category/{cat}/product/{slug} (villa/building designs) -> projects listing
    '#^category/[^/]+/product/.+#i' => 'projects',

    // Any other legacy multi-segment /category/.../... path -> projects listing
    // (real /category/{slug} is single-segment, so 2+ segments is always legacy)
    '#^category/[^/]+/.+#i' => 'projects',
];
