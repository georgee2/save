<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class SeoPage extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'seo_pages';
    protected $guarded = [];

    public static function getByKey(string $key): ?self
    {
        return self::where('page_key', $key)->first();
    }

    public static function getSeo(string $key, string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $page = self::getByKey($key);

        if (!$page) {
            return ['title' => null, 'description' => null, 'tags' => null];
        }

        return [
            'title' => $locale === 'ar' ? $page->seo_title_arabic : $page->seo_title_english,
            'description' => $locale === 'ar' ? $page->seo_description_arabic : $page->seo_description_english,
            'tags' => $page->seo_tags,
        ];
    }
}
