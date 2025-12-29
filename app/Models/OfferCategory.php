<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OfferCategory extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_categories';
    protected $guarded = [];
    
    /**
     * Get subcategories for this category
     */
    public function subCategories()
    {
        return $this->hasMany(OfferSubCategory::class, 'category_id');
    }
    
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
     * Get all offer categories for listing
     */
    public static function list()
    {
        return DB::table('offer_categories')
            ->select('id', 'title_english', 'title_arabic', 'bio_english', 'icon', 'slug', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed offer categories
     */
    public static function trashed()
    {
        return DB::table('offer_categories')
            ->select('id', 'title_english', 'title_arabic', 'slug', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find offer category by ID
     */
    public static function find($id)
    {
        return DB::table('offer_categories')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

