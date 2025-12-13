<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProjectConstructionCost extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'project_construction_costs';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    /**
     * Relationship: belongs to Feasibility Study Component
     */
    public function feasibilityStudyComponent()
    {
        return $this->belongsTo(FeasibilityStudyComponent::class, 'feasibility_study_component_id');
    }
    
    /**
     * Relationship: belongs to Substation Room
     */
    public function substationRoom()
    {
        return $this->belongsTo(SubstationRoom::class, 'substation_room_id');
    }
    
    /**
     * Relationship: belongs to Pumps Room
     */
    public function pumpsRoom()
    {
        return $this->belongsTo(PumpsRoom::class, 'pumps_room_id');
    }
    
    /**
     * Get all construction costs for a specific project
     */
    public static function getByProject($projectId)
    {
        return DB::table('project_construction_costs as pcc')
            ->join('feasibility_study_components as fsc', 'pcc.feasibility_study_component_id', '=', 'fsc.id')
            ->leftJoin('substation_rooms as sr', 'pcc.substation_room_id', '=', 'sr.id')
            ->leftJoin('pumps_rooms as pr', 'pcc.pumps_room_id', '=', 'pr.id')
            ->select(
                'pcc.id',
                'pcc.project_id',
                'pcc.feasibility_study_component_id',
                'pcc.substation_room_id',
                'pcc.pumps_room_id',
                'fsc.header_english as fsc_header_english',
                'fsc.header_arabic as fsc_header_arabic',
                'fsc.title_english as fsc_title_english',
                'fsc.title_arabic as fsc_title_arabic',
                'fsc.target as fsc_target',
                'sr.name_english as substation_name_english',
                'sr.name_arabic as substation_name_arabic',
                'sr.price as substation_price',
                'pr.name_english as pumps_name_english',
                'pr.name_arabic as pumps_name_arabic',
                'pr.price as pumps_price',
                'pcc.created_at',
                'pcc.updated_at'
            )
            ->where('pcc.project_id', $projectId)
            ->whereNull('pcc.deleted_at')
            ->whereNull('fsc.deleted_at')
            ->orderBy('pcc.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed construction costs for a specific project
     */
    public static function getTrashedByProject($projectId)
    {
        return DB::table('project_construction_costs as pcc')
            ->join('feasibility_study_components as fsc', 'pcc.feasibility_study_component_id', '=', 'fsc.id')
            ->leftJoin('substation_rooms as sr', 'pcc.substation_room_id', '=', 'sr.id')
            ->leftJoin('pumps_rooms as pr', 'pcc.pumps_room_id', '=', 'pr.id')
            ->select(
                'pcc.id',
                'pcc.project_id',
                'fsc.header_english as fsc_header_english',
                'sr.name_english as substation_name_english',
                'pr.name_english as pumps_name_english',
                'pcc.deleted_at'
            )
            ->where('pcc.project_id', $projectId)
            ->whereNotNull('pcc.deleted_at')
            ->orderBy('pcc.deleted_at', 'desc')
            ->get();
    }
}

