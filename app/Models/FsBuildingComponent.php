<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FsBuildingComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'fs_building_components';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Feasibility Study
     */
    public function feasibilityStudy()
    {
        return $this->belongsTo(FeasibilityStudy::class, 'feasibility_study_id');
    }
    
    /**
     * Relationship: belongs to Building Component
     */
    public function buildingComponent()
    {
        return $this->belongsTo(BuildingComponent::class, 'building_component_id');
    }
    
    /**
     * Get all building components for a specific study
     */
    public static function getByStudy($studyId)
    {
        return DB::table('fs_building_components as fsbc')
            ->join('building_components as bc', 'fsbc.building_component_id', '=', 'bc.id')
            ->select(
                'fsbc.id',
                'fsbc.feasibility_study_id',
                'fsbc.building_component_id',
                'fsbc.construction_cost',
                'bc.name_english',
                'bc.name_arabic',
                'bc.icon',
                'fsbc.created_at',
                'fsbc.updated_at'
            )
            ->where('fsbc.feasibility_study_id', $studyId)
            ->whereNull('fsbc.deleted_at')
            ->whereNull('bc.deleted_at')
            ->orderBy('fsbc.created_at', 'desc')
            ->get();
    }
}

