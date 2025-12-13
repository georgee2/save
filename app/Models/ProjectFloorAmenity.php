<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProjectFloorAmenity extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'project_floor_amenities';
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
     * Relationship: belongs to Amenity
     */
    public function amenity()
    {
        return $this->belongsTo(Amenity::class, 'amenity_id');
    }
    
    /**
     * Get all amenities for a specific floor
     */
    public static function getByFloor($floorId)
    {
        return DB::table('project_floor_amenities as pfa')
            ->join('amenities as a', 'pfa.amenity_id', '=', 'a.id')
            ->select(
                'pfa.id',
                'pfa.project_id',
                'pfa.floor_id',
                'pfa.amenity_id',
                'a.name_english as amenity_name_en',
                'a.name_arabic as amenity_name_ar',
                'a.icon as amenity_icon',
                'pfa.created_at',
                'pfa.updated_at'
            )
            ->where('pfa.floor_id', $floorId)
            ->whereNull('pfa.deleted_at')
            ->whereNull('a.deleted_at')
            ->orderBy('pfa.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed amenities for a specific floor
     */
    public static function getTrashedByFloor($floorId)
    {
        return DB::table('project_floor_amenities as pfa')
            ->join('amenities as a', 'pfa.amenity_id', '=', 'a.id')
            ->select(
                'pfa.id',
                'pfa.floor_id',
                'pfa.amenity_id',
                'a.name_english as amenity_name_en',
                'a.name_arabic as amenity_name_ar',
                'pfa.deleted_at'
            )
            ->where('pfa.floor_id', $floorId)
            ->whereNotNull('pfa.deleted_at')
            ->orderBy('pfa.deleted_at', 'desc')
            ->get();
    }
}

