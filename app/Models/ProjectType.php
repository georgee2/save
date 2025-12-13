<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectType extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'project_types';
    protected $guarded = [];
    
    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-generate slug from English name if not provided
        static::creating(function ($projectType) {
            if (empty($projectType->slug)) {
                $projectType->slug = Str::slug($projectType->name_english);
            }
        });
        
        static::updating(function ($projectType) {
            if (empty($projectType->slug)) {
                $projectType->slug = Str::slug($projectType->name_english);
            }
        });
    }
    
    /**
     * Get all project types for listing
     */
    public static function list()
    {
        return DB::table('project_types')
            ->select('id', 'name_english', 'name_arabic', 'image', 'icon', 'slug', 'status', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed project types
     */
    public static function trashed()
    {
        return DB::table('project_types')
            ->select('id', 'name_english', 'name_arabic', 'slug', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find project type by ID
     */
    public static function find($id)
    {
        return DB::table('project_types')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
    
    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return $this->status == 0 ? 'Active' : 'Not Active';
    }
    
    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status == 0 ? 'badge-success' : 'badge-danger';
    }
    
    /**
     * Relationship: Project Type has many Building Components
     */
    public function buildingComponents()
    {
        return $this->hasMany(BuildingComponent::class, 'project_type_id');
    }
    
    /**
     * Relationship: Project Type has many Income Components
     */
    public function incomeComponents()
    {
        return $this->hasMany(IncomeComponent::class, 'project_type_id');
    }
}

