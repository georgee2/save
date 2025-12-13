<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PumpsRoom extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'pumps_rooms';
    protected $guarded = [];
    
    /**
     * Relationship: Pumps Room belongs to Project Type
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
    
    /**
     * Get all pumps rooms for listing
     */
    public static function list()
    {
        return DB::table('pumps_rooms as pr')
            ->leftJoin('project_types as pt', 'pr.project_type_id', '=', 'pt.id')
            ->select('pr.id', 'pr.name_english', 'pr.name_arabic', 'pr.price', 'pt.name_english as project_type_name', 'pr.created_at', 'pr.updated_at')
            ->whereNull('pr.deleted_at')
            ->orderBy('pr.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed pumps rooms
     */
    public static function trashed()
    {
        return DB::table('pumps_rooms as pr')
            ->leftJoin('project_types as pt', 'pr.project_type_id', '=', 'pt.id')
            ->select('pr.id', 'pr.name_english', 'pr.name_arabic', 'pr.price', 'pt.name_english as project_type_name', 'pr.deleted_at')
            ->whereNotNull('pr.deleted_at')
            ->orderBy('pr.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find pumps room by ID
     */
    public static function find($id)
    {
        return DB::table('pumps_rooms')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

