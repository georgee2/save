<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class LengthComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'length_components';
    protected $guarded = [];
    
    /**
     * Relationship: Length Component belongs to Project Type
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
    
    /**
     * Relationship: Length Component belongs to Building Component
     */
    public function buildingComponent()
    {
        return $this->belongsTo(BuildingComponent::class, 'building_component_id');
    }
    
    /**
     * Get all length components for listing
     */
    public static function list()
    {
        return DB::table('length_components as lc')
            ->join('project_types as pt', 'lc.project_type_id', '=', 'pt.id')
            ->join('building_components as bc', 'lc.building_component_id', '=', 'bc.id')
            ->select(
                'lc.id', 
                'lc.name_english', 
                'lc.name_arabic', 
                'lc.icon', 
                'pt.name_english as project_type_name',
                'bc.name_english as building_component_name',
                'lc.created_at', 
                'lc.updated_at'
            )
            ->whereNull('lc.deleted_at')
            ->orderBy('lc.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed length components
     */
    public static function trashed()
    {
        return DB::table('length_components as lc')
            ->join('project_types as pt', 'lc.project_type_id', '=', 'pt.id')
            ->join('building_components as bc', 'lc.building_component_id', '=', 'bc.id')
            ->select(
                'lc.id', 
                'lc.name_english', 
                'lc.name_arabic', 
                'pt.name_english as project_type_name',
                'bc.name_english as building_component_name',
                'lc.deleted_at'
            )
            ->whereNotNull('lc.deleted_at')
            ->orderBy('lc.deleted_at', 'desc')
            ->get();
    }
}

