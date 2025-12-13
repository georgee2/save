<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FeasibilityStudyComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'feasibility_study_components';
    protected $guarded = [];
    
    /**
     * Relationship: Feasibility Study Component belongs to Project Type
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
    
    /**
     * Get all feasibility study components for listing
     */
    public static function list()
    {
        return DB::table('feasibility_study_components as fsc')
            ->join('project_types as pt', 'fsc.project_type_id', '=', 'pt.id')
            ->select(
                'fsc.id', 
                'fsc.project_type_id',
                'fsc.target',
                'fsc.header_english', 
                'fsc.header_arabic', 
                'fsc.title_english',
                'fsc.title_arabic',
                'fsc.status',
                'pt.name_english as project_type_name',
                'fsc.created_at', 
                'fsc.updated_at'
            )
            ->whereNull('fsc.deleted_at')
            ->orderBy('fsc.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed feasibility study components
     */
    public static function trashed()
    {
        return DB::table('feasibility_study_components as fsc')
            ->join('project_types as pt', 'fsc.project_type_id', '=', 'pt.id')
            ->select(
                'fsc.id', 
                'fsc.target',
                'fsc.header_english', 
                'fsc.header_arabic',
                'pt.name_english as project_type_name',
                'fsc.deleted_at'
            )
            ->whereNotNull('fsc.deleted_at')
            ->orderBy('fsc.deleted_at', 'desc')
            ->get();
    }
}

