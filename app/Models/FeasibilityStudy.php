<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FeasibilityStudy extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'feasibility_studies';
    protected $guarded = [];
    
    /**
     * Relationship: Feasibility Study belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    /**
     * Relationship: Feasibility Study belongs to User (creator)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Relationship: Feasibility Study belongs to Currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    
    /**
     * Relationship: has many Building Components
     */
    public function buildingComponents()
    {
        return $this->hasMany(FsBuildingComponent::class, 'feasibility_study_id');
    }
    
    /**
     * Relationship: has many Length Components
     */
    public function lengthComponents()
    {
        return $this->hasMany(FsLengthComponent::class, 'feasibility_study_id');
    }
    
    /**
     * Relationship: has many Income Components
     */
    public function incomeComponents()
    {
        return $this->hasMany(FsIncomeComponent::class, 'feasibility_study_id');
    }
    
    /**
     * Relationship: has many Construction Costs
     */
    public function constructionCosts()
    {
        return $this->hasMany(FsConstructionCost::class, 'feasibility_study_id');
    }
    
    /**
     * Relationship: has one Project Cost
     */
    public function projectCost()
    {
        return $this->hasOne(FsProjectCost::class, 'feasibility_study_id');
    }
    
    /**
     * Get all feasibility studies for listing
     */
    public static function list()
    {
        return DB::table('feasibility_studies as fs')
            ->join('projects as p', 'fs.project_id', '=', 'p.id')
            ->leftJoin('users as u', 'fs.created_by', '=', 'u.id')
            ->select(
                'fs.id',
                'fs.study_name',
                'fs.study_type',
                'fs.status',
                'fs.description',
                'p.title_english as project_name',
                'p.id as project_id',
                'u.name as creator_name',
                'fs.created_at',
                'fs.updated_at'
            )
            ->whereNull('fs.deleted_at')
            ->whereNull('p.deleted_at')
            ->orderBy('fs.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get all studies for a specific project
     */
    public static function getByProject($projectId)
    {
        return DB::table('feasibility_studies as fs')
            ->leftJoin('users as u', 'fs.created_by', '=', 'u.id')
            ->select(
                'fs.id',
                'fs.study_name',
                'fs.study_type',
                'fs.status',
                'fs.description',
                'u.name as creator_name',
                'fs.created_at',
                'fs.updated_at'
            )
            ->where('fs.project_id', $projectId)
            ->whereNull('fs.deleted_at')
            ->orderBy('fs.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed feasibility studies
     */
    public static function trashed()
    {
        return DB::table('feasibility_studies as fs')
            ->join('projects as p', 'fs.project_id', '=', 'p.id')
            ->select(
                'fs.id',
                'fs.study_name',
                'fs.study_type',
                'p.title_english as project_name',
                'fs.deleted_at'
            )
            ->whereNotNull('fs.deleted_at')
            ->orderBy('fs.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find feasibility study with relationships
     */
    public static function findWithRelations($id)
    {
        return DB::table('feasibility_studies as fs')
            ->join('projects as p', 'fs.project_id', '=', 'p.id')
            ->leftJoin('users as u', 'fs.created_by', '=', 'u.id')
            ->leftJoin('currencies as c', 'fs.currency_id', '=', 'c.id')
            ->select(
                'fs.*',
                'p.title_english as project_name_en',
                'p.title_arabic as project_name_ar',
                'p.type_id as project_type_id',
                'u.name as creator_name',
                'c.name_english as currency_name',
                'c.abbreviation as currency_abbreviation'
            )
            ->where('fs.id', $id)
            ->whereNull('fs.deleted_at')
            ->first();
    }
    
    /**
     * Check if study is master type
     */
    public function isMaster()
    {
        return $this->study_type === 'Master';
    }
    
    /**
     * Check if study is custom type
     */
    public function isCustom()
    {
        return $this->study_type === 'Custom';
    }
    
    /**
     * Check if study is active
     */
    public function isActive()
    {
        return $this->status === 'Active';
    }
}

