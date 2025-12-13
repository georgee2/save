<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProjectIncomeComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'project_income_components';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    /**
     * Relationship: belongs to Income Component
     */
    public function incomeComponent()
    {
        return $this->belongsTo(IncomeComponent::class, 'income_component_id');
    }
    
    /**
     * Get all income components for a specific project
     */
    public static function getByProject($projectId)
    {
        return DB::table('project_income_components as pic')
            ->join('income_components as ic', 'pic.income_component_id', '=', 'ic.id')
            ->select(
                'pic.id',
                'pic.project_id',
                'pic.income_component_id',
                'pic.number_of_units',
                'pic.rent_per_year',
                'ic.name_english',
                'ic.name_arabic',
                'ic.icon',
                'pic.created_at',
                'pic.updated_at'
            )
            ->where('pic.project_id', $projectId)
            ->whereNull('pic.deleted_at')
            ->whereNull('ic.deleted_at')
            ->orderBy('pic.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed income components for a specific project
     */
    public static function getTrashedByProject($projectId)
    {
        return DB::table('project_income_components as pic')
            ->join('income_components as ic', 'pic.income_component_id', '=', 'ic.id')
            ->select(
                'pic.id',
                'pic.project_id',
                'pic.income_component_id',
                'pic.number_of_units',
                'pic.rent_per_year',
                'ic.name_english',
                'ic.name_arabic',
                'pic.deleted_at'
            )
            ->where('pic.project_id', $projectId)
            ->whereNotNull('pic.deleted_at')
            ->orderBy('pic.deleted_at', 'desc')
            ->get();
    }
}

