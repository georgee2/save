<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProjectBuildingComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'project_building_components';
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
     * Get all building components for a specific project
     */
    public static function getByProject($projectId)
    {
        return DB::table('project_building_components as pbc')
            ->join('building_components as bc', 'pbc.building_component_id', '=', 'bc.id')
            ->select(
                'pbc.id',
                'pbc.project_id',
                'pbc.building_component_id',
                'pbc.construction_cost',
                'bc.name_english',
                'bc.name_arabic',
                'bc.icon',
                'pbc.created_at',
                'pbc.updated_at'
            )
            ->where('pbc.project_id', $projectId)
            ->whereNull('pbc.deleted_at')
            ->whereNull('bc.deleted_at')
            ->orderBy('pbc.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed building components for a specific project
     */
    public static function getTrashedByProject($projectId)
    {
        return DB::table('project_building_components as pbc')
            ->join('building_components as bc', 'pbc.building_component_id', '=', 'bc.id')
            ->select(
                'pbc.id',
                'pbc.project_id',
                'pbc.building_component_id',
                'pbc.construction_cost',
                'bc.name_english',
                'bc.name_arabic',
                'pbc.deleted_at'
            )
            ->where('pbc.project_id', $projectId)
            ->whereNotNull('pbc.deleted_at')
            ->orderBy('pbc.deleted_at', 'desc')
            ->get();
    }
}

