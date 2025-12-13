<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class IncomeComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'income_components';
    protected $guarded = [];
    
    /**
     * Relationship: Income Component belongs to Project Type
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
    
    /**
     * Get all income components for listing
     */
    public static function list()
    {
        return DB::table('income_components as ic')
            ->join('project_types as pt', 'ic.project_type_id', '=', 'pt.id')
            ->select('ic.id', 'ic.name_english', 'ic.name_arabic', 'ic.icon', 'pt.name_english as project_type_name', 'ic.created_at', 'ic.updated_at')
            ->whereNull('ic.deleted_at')
            ->orderBy('ic.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed income components
     */
    public static function trashed()
    {
        return DB::table('income_components as ic')
            ->join('project_types as pt', 'ic.project_type_id', '=', 'pt.id')
            ->select('ic.id', 'ic.name_english', 'ic.name_arabic', 'pt.name_english as project_type_name', 'ic.deleted_at')
            ->whereNotNull('ic.deleted_at')
            ->orderBy('ic.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find income component by ID
     */
    public static function find($id)
    {
        return DB::table('income_components')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}


