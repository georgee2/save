<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OfferSubCategory extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_sub_categories';
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
     * Get the parent category
     */
    public function category()
    {
        return $this->belongsTo(OfferCategory::class, 'category_id');
    }
    
    /**
     * Get all offer sub categories for listing
     */
    public static function list()
    {
        return DB::table('offer_sub_categories')
            ->leftJoin('offer_categories', 'offer_sub_categories.category_id', '=', 'offer_categories.id')
            ->select(
                'offer_sub_categories.id',
                'offer_sub_categories.title_english',
                'offer_sub_categories.title_arabic',
                'offer_sub_categories.bio_english',
                'offer_sub_categories.icon',
                'offer_sub_categories.slug',
                'offer_sub_categories.created_at',
                'offer_sub_categories.updated_at',
                'offer_categories.title_english as category_title_english',
                'offer_categories.title_arabic as category_title_arabic'
            )
            ->whereNull('offer_sub_categories.deleted_at')
            ->orderBy('offer_sub_categories.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed offer sub categories
     */
    public static function trashed()
    {
        return DB::table('offer_sub_categories')
            ->leftJoin('offer_categories', 'offer_sub_categories.category_id', '=', 'offer_categories.id')
            ->select(
                'offer_sub_categories.id',
                'offer_sub_categories.title_english',
                'offer_sub_categories.title_arabic',
                'offer_sub_categories.slug',
                'offer_sub_categories.deleted_at',
                'offer_categories.title_english as category_title_english'
            )
            ->whereNotNull('offer_sub_categories.deleted_at')
            ->orderBy('offer_sub_categories.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find offer sub category by ID
     */
    public static function find($id)
    {
        return DB::table('offer_sub_categories')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

