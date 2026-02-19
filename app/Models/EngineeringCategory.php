<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class EngineeringCategory extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $logTitleField = 'title_english';
    
    protected $table = 'engineering_categories';
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
     * Get all engineering categories for listing
     */
    public static function list()
    {
        return DB::table('engineering_categories')
            ->select('id', 'title_english', 'title_arabic', 'bio_english', 'icon', 'image', 'slug', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed engineering categories
     */
    public static function trashed()
    {
        return DB::table('engineering_categories')
            ->select('id', 'title_english', 'title_arabic', 'slug', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find engineering category by ID
     */
    public static function find($id)
    {
        return DB::table('engineering_categories')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
    
    /**
     * Relationship: Category has many Sub Categories
     */
    public function subCategories()
    {
        return $this->hasMany(EngineeringSubCategory::class, 'category_id');
    }
    
    /**
     * Relationship: Category has many Projects
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }
    
    /**
     * Relationship: Category has one Home Project Setting
     */
    public function homeProjectSetting()
    {
        return $this->hasOne(HomeProjectSetting::class, 'category_id');
    }
}

