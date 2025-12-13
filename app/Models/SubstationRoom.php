<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SubstationRoom extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'substation_rooms';
    protected $guarded = [];
    
    /**
     * Relationship: Substation Room belongs to Project Type
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
    
    /**
     * Get all substation rooms for listing
     */
    public static function list()
    {
        return DB::table('substation_rooms as sr')
            ->leftJoin('project_types as pt', 'sr.project_type_id', '=', 'pt.id')
            ->select('sr.id', 'sr.name_english', 'sr.name_arabic', 'sr.price', 'pt.name_english as project_type_name', 'sr.created_at', 'sr.updated_at')
            ->whereNull('sr.deleted_at')
            ->orderBy('sr.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed substation rooms
     */
    public static function trashed()
    {
        return DB::table('substation_rooms as sr')
            ->leftJoin('project_types as pt', 'sr.project_type_id', '=', 'pt.id')
            ->select('sr.id', 'sr.name_english', 'sr.name_arabic', 'sr.price', 'pt.name_english as project_type_name', 'sr.deleted_at')
            ->whereNotNull('sr.deleted_at')
            ->orderBy('sr.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find substation room by ID
     */
    public static function find($id)
    {
        return DB::table('substation_rooms')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

