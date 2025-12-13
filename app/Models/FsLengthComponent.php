<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FsLengthComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'fs_length_components';
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
     * Relationship: belongs to Length Component
     */
    public function lengthComponent()
    {
        return $this->belongsTo(LengthComponent::class, 'length_component_id');
    }
    
    /**
     * Get all length components for a specific study
     */
    public static function getByStudy($studyId)
    {
        return DB::table('fs_length_components as fslc')
            ->join('building_components as bc', 'fslc.building_component_id', '=', 'bc.id')
            ->join('length_components as lc', 'fslc.length_component_id', '=', 'lc.id')
            ->select(
                'fslc.id',
                'fslc.feasibility_study_id',
                'fslc.building_component_id',
                'fslc.length_component_id',
                'fslc.unit_cost',
                'bc.name_english as building_component_name_en',
                'bc.name_arabic as building_component_name_ar',
                'lc.name_english as length_component_name_en',
                'lc.name_arabic as length_component_name_ar',
                'lc.icon',
                'fslc.created_at',
                'fslc.updated_at'
            )
            ->where('fslc.feasibility_study_id', $studyId)
            ->whereNull('fslc.deleted_at')
            ->whereNull('bc.deleted_at')
            ->whereNull('lc.deleted_at')
            ->orderBy('fslc.created_at', 'desc')
            ->get();
    }
}

