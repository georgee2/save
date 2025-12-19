<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Emirate extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'emirates';
    protected $guarded = [];
    
    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-generate slug from English title if not provided
        static::creating(function ($emirate) {
            if (empty($emirate->slug)) {
                $emirate->slug = Str::slug($emirate->title_english);
            }
        });
        
        static::updating(function ($emirate) {
            if (empty($emirate->slug)) {
                $emirate->slug = Str::slug($emirate->title_english);
            }
        });
    }
    
    /**
     * Get all emirates for listing
     */
    public static function list()
    {
        return DB::table('emirates')
            ->select('id', 'title_english', 'title_arabic', 'bio_english', 'icon', 'image', 'slug', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed emirates
     */
    public static function trashed()
    {
        return DB::table('emirates')
            ->select('id', 'title_english', 'title_arabic', 'slug', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find emirate by ID
     */
    public static function find($id)
    {
        return DB::table('emirates')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

