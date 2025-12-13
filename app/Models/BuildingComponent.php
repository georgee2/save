<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class BuildingComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'building_components';
    protected $guarded = [];
    
    /**
     * Relationship: Building Component belongs to Project Type
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
    
    /**
     * Relationship: Building Component has many Floor Components
     */
    public function floorComponents()
    {
        return $this->hasMany(FloorComponent::class, 'component_id');
    }
    
    /**
     * Get all building components for listing
     */
    public static function list()
    {
        return DB::table('building_components as bc')
            ->join('project_types as pt', 'bc.project_type_id', '=', 'pt.id')
            ->select('bc.id', 'bc.name_english', 'bc.name_arabic', 'bc.icon', 'bc.is_length', 'pt.name_english as project_type_name', 'bc.created_at', 'bc.updated_at')
            ->whereNull('bc.deleted_at')
            ->orderBy('bc.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed building components
     */
    public static function trashed()
    {
        return DB::table('building_components as bc')
            ->join('project_types as pt', 'bc.project_type_id', '=', 'pt.id')
            ->select('bc.id', 'bc.name_english', 'bc.name_arabic', 'pt.name_english as project_type_name', 'bc.deleted_at')
            ->whereNotNull('bc.deleted_at')
            ->orderBy('bc.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find building component by ID
     */
    public static function find($id)
    {
        return DB::table('building_components')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

