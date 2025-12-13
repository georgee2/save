<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProjectSpecification extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'project_specifications';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    /**
     * Relationship: belongs to Specification
     */
    public function specification()
    {
        return $this->belongsTo(Specification::class, 'specification_id');
    }
    
    /**
     * Get all specifications for a specific project
     */
    public static function getByProject($projectId)
    {
        return DB::table('project_specifications as ps')
            ->join('specifications as s', 'ps.specification_id', '=', 's.id')
            ->select(
                'ps.id',
                'ps.project_id',
                'ps.specification_id',
                'ps.value_english',
                'ps.value_arabic',
                's.title_english',
                's.title_arabic',
                's.icon',
                'ps.created_at',
                'ps.updated_at'
            )
            ->where('ps.project_id', $projectId)
            ->whereNull('ps.deleted_at')
            ->whereNull('s.deleted_at')
            ->orderBy('ps.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed specifications for a specific project
     */
    public static function getTrashedByProject($projectId)
    {
        return DB::table('project_specifications as ps')
            ->join('specifications as s', 'ps.specification_id', '=', 's.id')
            ->select(
                'ps.id',
                'ps.project_id',
                'ps.specification_id',
                'ps.value_english',
                'ps.value_arabic',
                's.title_english',
                's.title_arabic',
                'ps.deleted_at'
            )
            ->where('ps.project_id', $projectId)
            ->whereNotNull('ps.deleted_at')
            ->orderBy('ps.deleted_at', 'desc')
            ->get();
    }
}

