<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class EngineeringSubCategory extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $logTitleField = 'title_english';
    
    protected $table = 'engineering_sub_categories';
    protected $guarded = [];
    
    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-generate slug from English title if not provided
        static::creating(function ($subCategory) {
            if (empty($subCategory->slug)) {
                $subCategory->slug = Str::slug($subCategory->title_english);
            }
        });
        
        static::updating(function ($subCategory) {
            if (empty($subCategory->slug)) {
                $subCategory->slug = Str::slug($subCategory->title_english);
            }
        });
    }
    
    /**
     * Relationship: Sub Category belongs to Category
     */
    public function category()
    {
        return $this->belongsTo(EngineeringCategory::class, 'category_id');
    }
    
    /**
     * Relationship: Sub Category has many Projects
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'subcategory_id');
    }
    
    /**
     * Get all engineering sub categories for listing
     */
    public static function list()
    {
        return DB::table('engineering_sub_categories as esc')
            ->join('engineering_categories as ec', 'esc.category_id', '=', 'ec.id')
            ->select('esc.id', 'esc.title_english', 'esc.title_arabic', 'esc.bio_english', 'esc.icon', 'esc.image', 'esc.slug', 'ec.title_english as category_name', 'esc.created_at', 'esc.updated_at')
            ->whereNull('esc.deleted_at')
            ->orderBy('esc.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed engineering sub categories
     */
    public static function trashed()
    {
        return DB::table('engineering_sub_categories as esc')
            ->join('engineering_categories as ec', 'esc.category_id', '=', 'ec.id')
            ->select('esc.id', 'esc.title_english', 'esc.title_arabic', 'esc.slug', 'ec.title_english as category_name', 'esc.deleted_at')
            ->whereNotNull('esc.deleted_at')
            ->orderBy('esc.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find engineering sub category by ID
     */
    public static function find($id)
    {
        return DB::table('engineering_sub_categories')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

