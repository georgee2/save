<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InteriorDesignGallery extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'interior_design_galleries';
    protected $guarded = [];
    
    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-generate slug from English title if not provided
        static::creating(function ($gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title_english);
            }
        });
        
        static::updating(function ($gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title_english);
            }
        });
    }
    
    /**
     * Get all interior design galleries for listing
     */
    public static function list()
    {
        return DB::table('interior_design_galleries as idg')
            ->leftJoin('interior_categories as ic', 'idg.category_id', '=', 'ic.id')
            ->leftJoin('projects as p', 'idg.project_id', '=', 'p.id')
            ->leftJoin('project_styles as ps', 'idg.project_style_id', '=', 'ps.id')
            ->leftJoin('project_types as pt', 'idg.project_type_id', '=', 'pt.id')
            ->leftJoin('emirates as e', 'idg.emirate_id', '=', 'e.id')
            ->select(
                'idg.id', 
                'idg.title_english', 
                'idg.title_arabic', 
                'idg.bio_english',
                'idg.image', 
                'idg.publish_status',
                'idg.home_status',
                'idg.ordering',
                'idg.slug', 
                'idg.created_at', 
                'idg.updated_at',
                'ic.title_english as category_name',
                'p.title_english as project_name',
                'ps.title_english as style_name',
                'pt.name_english as type_name',
                'e.title_english as emirate_name'
            )
            ->whereNull('idg.deleted_at')
            ->orderBy('idg.ordering', 'asc')
            ->orderBy('idg.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed interior design galleries
     */
    public static function trashed()
    {
        return DB::table('interior_design_galleries')
            ->select('id', 'title_english', 'title_arabic', 'slug', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Relationship: Gallery belongs to Category
     */
    public function category()
    {
        return $this->belongsTo(InteriorCategory::class, 'category_id');
    }
    
    /**
     * Relationship: Gallery belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    /**
     * Relationship: Gallery belongs to Project Style
     */
    public function projectStyle()
    {
        return $this->belongsTo(ProjectStyle::class, 'project_style_id');
    }
    
    /**
     * Relationship: Gallery belongs to Project Type
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
    
    /**
     * Relationship: Gallery belongs to Emirate
     */
    public function emirate()
    {
        return $this->belongsTo(Emirate::class, 'emirate_id');
    }
    
    /**
     * Scope: Published galleries
     */
    public function scopePublished($query)
    {
        return $query->where('publish_status', 0);
    }
    
    /**
     * Scope: Show on home
     */
    public function scopeShowOnHome($query)
    {
        return $query->where('home_status', 0);
    }
}
