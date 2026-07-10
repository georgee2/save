<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Guarantees a unique `slug` before every save by appending -1, -2, … on
 * collision. Prevents the "SQLSTATE 1062 Duplicate entry for key ..._slug_unique"
 * 500 that occurs when two titles slugify to the same value.
 *
 * Runs on the model `saving` event, so it works regardless of which admin
 * controller performs the write. Only acts when `slug` actually changed, so
 * ordinary saves (e.g. toggling publish_status) incur no overhead.
 *
 * Composes with RecordsSlugRedirects: this normalises the slug during `saving`,
 * then RecordsSlugRedirects records the old->new 301 during `updated`.
 */
trait HasUniqueSlug
{
    public static function bootHasUniqueSlug(): void
    {
        static::saving(function ($model): void {
            if (!$model->isDirty('slug') || empty($model->slug)) {
                return;
            }

            $base = Str::slug($model->slug);
            if ($base === '') {
                return;
            }

            $slug = $base;
            $i = 1;
            while ($model->slugExistsForAnother($slug)) {
                $slug = $base . '-' . $i++;
            }

            $model->slug = $slug;
        });
    }

    protected function slugExistsForAnother(string $slug): bool
    {
        $query = static::query()->where('slug', $slug);

        // Include soft-deleted rows so we don't collide with a trashed unique slug.
        if (in_array(SoftDeletes::class, class_uses_recursive(static::class), true)) {
            $query->withTrashed();
        }

        // Exclude self on update.
        if ($key = $this->getKey()) {
            $query->where($this->getKeyName(), '!=', $key);
        }

        return $query->exists();
    }
}
