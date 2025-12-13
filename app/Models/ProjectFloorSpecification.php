<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProjectFloorSpecification extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'project_floor_specifications';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    /**
     * Relationship: belongs to Project Floor
     */
    public function floor()
    {
        return $this->belongsTo(ProjectFloor::class, 'floor_id');
    }
    
    /**
     * Relationship: belongs to Specification
     */
    public function specification()
    {
        return $this->belongsTo(Specification::class, 'specification_id');
    }
    
    /**
     * Get all specifications for a specific floor
     */
    public static function getByFloor($floorId)
    {
        return DB::table('project_floor_specifications as pfs')
            ->join('specifications as s', 'pfs.specification_id', '=', 's.id')
            ->select(
                'pfs.id',
                'pfs.project_id',
                'pfs.floor_id',
                'pfs.specification_id',
                'pfs.value_english',
                'pfs.value_arabic',
                's.title_english as specification_title_en',
                's.title_arabic as specification_title_ar',
                's.icon as specification_icon',
                'pfs.created_at',
                'pfs.updated_at'
            )
            ->where('pfs.floor_id', $floorId)
            ->whereNull('pfs.deleted_at')
            ->whereNull('s.deleted_at')
            ->orderBy('pfs.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed specifications for a specific floor
     */
    public static function getTrashedByFloor($floorId)
    {
        return DB::table('project_floor_specifications as pfs')
            ->join('specifications as s', 'pfs.specification_id', '=', 's.id')
            ->select(
                'pfs.id',
                'pfs.floor_id',
                'pfs.specification_id',
                'pfs.value_english',
                'pfs.value_arabic',
                's.title_english as specification_title_en',
                's.title_arabic as specification_title_ar',
                'pfs.deleted_at'
            )
            ->where('pfs.floor_id', $floorId)
            ->whereNotNull('pfs.deleted_at')
            ->orderBy('pfs.deleted_at', 'desc')
            ->get();
    }
}

