<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProjectFloor extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'project_floors';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    /**
     * Relationship: belongs to Building Component
     */
    public function buildingComponent()
    {
        return $this->belongsTo(BuildingComponent::class, 'building_component_id');
    }
    
    /**
     * Relationship: belongs to Floor Component
     */
    public function floorComponent()
    {
        return $this->belongsTo(FloorComponent::class, 'floor_component_id');
    }
    
    /**
     * Relationship: has many Floor Specifications
     */
    public function specifications()
    {
        return $this->hasMany(ProjectFloorSpecification::class, 'floor_id');
    }
    
    /**
     * Relationship: has many Floor Amenities
     */
    public function amenities()
    {
        return $this->hasMany(ProjectFloorAmenity::class, 'floor_id');
    }
    
    /**
     * Get all floors for a specific project
     */
    public static function getByProject($projectId)
    {
        return DB::table('project_floors as pf')
            ->join('building_components as bc', 'pf.building_component_id', '=', 'bc.id')
            ->join('floor_components as fc', 'pf.floor_component_id', '=', 'fc.id')
            ->select(
                'pf.id',
                'pf.project_id',
                'pf.building_component_id',
                'pf.floor_component_id',
                'pf.sqft',
                'pf.sqm',
                'pf.count',
                'pf.image_2d',
                'pf.image_3d',
                'bc.name_english as building_component_name_en',
                'bc.name_arabic as building_component_name_ar',
                'bc.icon as building_component_icon',
                'fc.name_english as floor_component_name_en',
                'fc.name_arabic as floor_component_name_ar',
                'fc.icon as floor_component_icon',
                'pf.created_at',
                'pf.updated_at'
            )
            ->where('pf.project_id', $projectId)
            ->whereNull('pf.deleted_at')
            ->whereNull('bc.deleted_at')
            ->whereNull('fc.deleted_at')
            ->orderBy('pf.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed floors for a specific project
     */
    public static function getTrashedByProject($projectId)
    {
        return DB::table('project_floors as pf')
            ->join('building_components as bc', 'pf.building_component_id', '=', 'bc.id')
            ->join('floor_components as fc', 'pf.floor_component_id', '=', 'fc.id')
            ->select(
                'pf.id',
                'pf.project_id',
                'pf.building_component_id',
                'pf.floor_component_id',
                'pf.sqft',
                'pf.sqm',
                'pf.count',
                'bc.name_english as building_component_name_en',
                'bc.name_arabic as building_component_name_ar',
                'fc.name_english as floor_component_name_en',
                'fc.name_arabic as floor_component_name_ar',
                'pf.deleted_at'
            )
            ->where('pf.project_id', $projectId)
            ->whereNotNull('pf.deleted_at')
            ->orderBy('pf.deleted_at', 'desc')
            ->get();
    }
}

