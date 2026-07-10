<?php

namespace App\Traits;

use App\Http\Middleware\LegacyRedirect;
use App\Models\UrlRedirect;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Automatically records a 301 redirect whenever a model's `slug` changes, so
 * the old public URL keeps working instead of turning into a Search Console
 * "Not found (404)". Redirects are written for every supported locale.
 *
 * Each consuming model must declare the public route prefix, e.g.:
 *
 *     protected string $slugRedirectPrefix = 'offers';
 *
 * so the path is built as "{locale}/{prefix}/{slug}". A model exposed under
 * several prefixes (e.g. subcategories served at /subcategory/{slug} AND
 * /engineering/{slug}) may declare an array:
 *
 *     protected array $slugRedirectPrefix = ['subcategory', 'engineering'];
 *
 * Never let this bookkeeping break a content save — all writes are guarded.
 */
trait RecordsSlugRedirects
{
    /** Locales the site serves (matches config/laravellocalization.php). */
    protected static array $slugRedirectLocales = ['en', 'ar'];

    public static function bootRecordsSlugRedirects(): void
    {
        static::updated(function ($model): void {
            if (!$model->wasChanged('slug')) {
                return;
            }

            $old = $model->getOriginal('slug');
            $new = $model->slug;

            if (empty($old) || empty($new) || $old === $new) {
                return;
            }

            $model->recordSlugRedirect($old, $new);
        });
    }

    protected function recordSlugRedirect(string $oldSlug, string $newSlug): void
    {
        $prefixes = array_filter((array) ($this->slugRedirectPrefix ?? []));
        if (empty($prefixes)) {
            return;
        }

        try {
            foreach ($prefixes as $prefix) {
                foreach (static::$slugRedirectLocales as $locale) {
                    $fromPath = "{$locale}/{$prefix}/{$oldSlug}";
                    $toPath   = "{$locale}/{$prefix}/{$newSlug}";

                    // Repoint any existing redirects that targeted the old slug so we
                    // never build a chain (A->B then B->C becomes A->C, B->C).
                    UrlRedirect::where('to_path', $fromPath)->update(['to_path' => $toPath]);

                    UrlRedirect::updateOrCreate(
                        ['from_path' => $fromPath],
                        ['to_path' => $toPath, 'status_code' => 301, 'is_active' => true]
                    );
                }
            }

            Cache::forget(LegacyRedirect::CACHE_KEY);
        } catch (\Throwable $e) {
            // Bookkeeping must never block a content save.
            Log::warning('RecordsSlugRedirects failed: ' . $e->getMessage());
        }
    }
}
