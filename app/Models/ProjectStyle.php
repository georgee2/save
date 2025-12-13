<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectStyle extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'project_styles';
    protected $guarded = [];
    
    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-generate slug from English title if not provided
        static::creating(function ($projectStyle) {
            if (empty($projectStyle->slug)) {
                $projectStyle->slug = Str::slug($projectStyle->title_english);
            }
        });
        
        static::updating(function ($projectStyle) {
            if (empty($projectStyle->slug)) {
                $projectStyle->slug = Str::slug($projectStyle->title_english);
            }
        });
    }
    
    /**
     * Get all project styles for listing
     */
    public static function list()
    {
        return DB::table('project_styles')
            ->select('id', 'title_english', 'title_arabic', 'bio_english', 'icon', 'image', 'slug', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed project styles
     */
    public static function trashed()
    {
        return DB::table('project_styles')
            ->select('id', 'title_english', 'title_arabic', 'slug', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find project style by ID
     */
    public static function find($id)
    {
        return DB::table('project_styles')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

