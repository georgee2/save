<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InteriorCategory extends Model
{
    use HasFactory, SoftDeletes;
    
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
            ->select('id', 'title_english', 'title_arabic', 'bio_english', 'icon', 'image', 'slug', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
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
     * Relationship: Category has many Sub Categories
     */
    public function subCategories()
    {
        return $this->hasMany(InteriorSubCategory::class, 'category_id');
    }
    
    /**
     * Relationship: Category has many Projects
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'interior_category_id');
    }
}
