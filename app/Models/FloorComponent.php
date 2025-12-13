<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FloorComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'floor_components';
    protected $guarded = [];
    
    /**
     * Relationship: Floor Component belongs to Project Type
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
    
    /**
     * Relationship: Floor Component belongs to Building Component
     */
    public function buildingComponent()
    {
        return $this->belongsTo(BuildingComponent::class, 'component_id');
    }
    
    /**
     * Get all floor components for listing
     */
    public static function list()
    {
        return DB::table('floor_components as fc')
            ->join('project_types as pt', 'fc.project_type_id', '=', 'pt.id')
            ->join('building_components as bc', 'fc.component_id', '=', 'bc.id')
            ->select('fc.id', 'fc.name_english', 'fc.name_arabic', 'fc.icon', 
                     'pt.name_english as project_type_name', 'bc.name_english as component_name', 
                     'fc.created_at', 'fc.updated_at')
            ->whereNull('fc.deleted_at')
            ->orderBy('fc.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed floor components
     */
    public static function trashed()
    {
        return DB::table('floor_components as fc')
            ->join('project_types as pt', 'fc.project_type_id', '=', 'pt.id')
            ->join('building_components as bc', 'fc.component_id', '=', 'bc.id')
            ->select('fc.id', 'fc.name_english', 'fc.name_arabic', 
                     'pt.name_english as project_type_name', 'bc.name_english as component_name', 
                     'fc.deleted_at')
            ->whereNotNull('fc.deleted_at')
            ->orderBy('fc.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find floor component by ID
     */
    public static function find($id)
    {
        return DB::table('floor_components')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

