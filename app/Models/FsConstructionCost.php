<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FsConstructionCost extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'fs_construction_costs';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Feasibility Study
     */
    public function feasibilityStudy()
    {
        return $this->belongsTo(FeasibilityStudy::class, 'feasibility_study_id');
    }
    
    /**
     * Relationship: belongs to Substation Room
     */
    public function substationRoom()
    {
        return $this->belongsTo(SubstationRoom::class, 'substation_room_id');
    }
    
    /**
     * Relationship: belongs to Pumps Room
     */
    public function pumpsRoom()
    {
        return $this->belongsTo(PumpsRoom::class, 'pumps_room_id');
    }
    
    /**
     * Get all construction costs for a specific study
     */
    public static function getByStudy($studyId)
    {
        return DB::table('fs_construction_costs as fscc')
            ->leftJoin('substation_rooms as sr', 'fscc.substation_room_id', '=', 'sr.id')
            ->leftJoin('pumps_rooms as pr', 'fscc.pumps_room_id', '=', 'pr.id')
            ->select(
                'fscc.id',
                'fscc.feasibility_study_id',
                'fscc.substation_room_id',
                'fscc.substation_cost',
                'fscc.pumps_room_id',
                'fscc.pumps_cost',
                'sr.name_english as substation_name_en',
                'sr.name_arabic as substation_name_ar',
                'pr.name_english as pumps_name_en',
                'pr.name_arabic as pumps_name_ar',
                'fscc.created_at',
                'fscc.updated_at'
            )
            ->where('fscc.feasibility_study_id', $studyId)
            ->whereNull('fscc.deleted_at')
            ->first();
    }
    
    /**
     * Calculate total construction cost
     */
    public function calculateTotal()
    {
        return ($this->substation_cost ?? 0) + ($this->pumps_cost ?? 0);
    }
}

