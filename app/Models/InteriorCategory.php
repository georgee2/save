<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;
use App\Traits\RecordsSlugRedirects;
use App\Traits\HasUniqueSlug;

class InteriorCategory extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, RecordsSlugRedirects, HasUniqueSlug;

    /** Public route prefix for auto slug-change redirects (see RecordsSlugRedirects). */
    protected string $slugRedirectPrefix = 'interior-design/category';
    
    protected $logTitleField = 'title_english';
    
    protected $table = 'interior_categories';
    protected $guarded = [];
    
    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-generate slug from English title if not provided
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title_english);
            }
        });
        
        static::updating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title_english);
            }
        });
    }
    
    /**
     * Get all interior categories for listing
     */
    public static function list()
    {
        return DB::table('interior_categories')
            ->select('id', 'title_english', 'title_arabic', 'bio_english', 'icon', 'image', 'slug', 'ordering', 'publish_status', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
    }
    
    /**
     * Get trashed interior categories
     */
    public static function trashed()
    {
        return DB::table('interior_categories')
            ->select('id', 'title_english', 'title_arabic', 'slug', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find interior category by ID
     */
    public static function find($id)
    {
        return DB::table('interior_categories')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
    
    /**
     * Relationship: Category has many Projects
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'interior_category_id');
    }
    
    /**
     * Relationship: Category has many Interior Design Galleries
     */
    public function galleries()
    {
        return $this->hasMany(InteriorDesignGallery::class, 'category_id');
    }
}
