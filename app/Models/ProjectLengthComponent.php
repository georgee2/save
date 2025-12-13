<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProjectLengthComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'project_length_components';
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
     * Relationship: belongs to Length Component
     */
    public function lengthComponent()
    {
        return $this->belongsTo(LengthComponent::class, 'length_component_id');
    }
    
    /**
     * Get all length components for a specific project
     */
    public static function getByProject($projectId)
    {
        return DB::table('project_length_components as plc')
            ->join('building_components as bc', 'plc.building_component_id', '=', 'bc.id')
            ->join('length_components as lc', 'plc.length_component_id', '=', 'lc.id')
            ->select(
                'plc.id',
                'plc.project_id',
                'plc.building_component_id',
                'plc.length_component_id',
                'plc.unit_cost',
                'bc.name_english as building_component_name_english',
                'bc.name_arabic as building_component_name_arabic',
                'bc.icon as building_component_icon',
                'lc.name_english as length_component_name_english',
                'lc.name_arabic as length_component_name_arabic',
                'lc.icon as length_component_icon',
                'plc.created_at',
                'plc.updated_at'
            )
            ->where('plc.project_id', $projectId)
            ->whereNull('plc.deleted_at')
            ->whereNull('bc.deleted_at')
            ->whereNull('lc.deleted_at')
            ->orderBy('plc.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed length components for a specific project
     */
    public static function getTrashedByProject($projectId)
    {
        return DB::table('project_length_components as plc')
            ->join('building_components as bc', 'plc.building_component_id', '=', 'bc.id')
            ->join('length_components as lc', 'plc.length_component_id', '=', 'lc.id')
            ->select(
                'plc.id',
                'plc.project_id',
                'plc.building_component_id',
                'plc.length_component_id',
                'plc.unit_cost',
                'bc.name_english as building_component_name_english',
                'lc.name_english as length_component_name_english',
                'plc.deleted_at'
            )
            ->where('plc.project_id', $projectId)
            ->whereNotNull('plc.deleted_at')
            ->orderBy('plc.deleted_at', 'desc')
            ->get();
    }
}

