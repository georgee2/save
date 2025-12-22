<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferFsConstructionCost extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_fs_construction_costs';
    protected $guarded = [];
    
    public function feasibilityStudy()
    {
        return $this->belongsTo(OfferFeasibilityStudy::class, 'offer_feasibility_study_id');
    }
    
    public function substationRoom()
    {
        return $this->belongsTo(SubstationRoom::class, 'substation_room_id');
    }
    
    public function pumpsRoom()
    {
        return $this->belongsTo(PumpsRoom::class, 'pumps_room_id');
    }
    
    public static function getByStudy($studyId)
    {
        return DB::table('offer_fs_construction_costs as ofcc')
            ->leftJoin('substation_rooms as sr', 'ofcc.substation_room_id', '=', 'sr.id')
            ->leftJoin('pumps_rooms as pr', 'ofcc.pumps_room_id', '=', 'pr.id')
            ->select(
                'ofcc.id',
                'ofcc.offer_feasibility_study_id',
                'ofcc.substation_room_id',
                'ofcc.substation_cost',
                'ofcc.pumps_room_id',
                'ofcc.pumps_cost',
                'sr.name_english as substation_name_en',
                'sr.name_arabic as substation_name_ar',
                'pr.name_english as pumps_name_en',
                'pr.name_arabic as pumps_name_ar'
            )
            ->where('ofcc.offer_feasibility_study_id', $studyId)
            ->whereNull('ofcc.deleted_at')
            ->first();
    }
}

