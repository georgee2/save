<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferConstructionCost extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_construction_costs';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Offer
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
    
    /**
     * Relationship: belongs to Feasibility Study Component
     */
    public function feasibilityStudyComponent()
    {
        return $this->belongsTo(FeasibilityStudyComponent::class, 'feasibility_study_component_id');
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
     * Get all construction costs for a specific offer
     */
    public static function getByOffer($offerId)
    {
        return DB::table('offer_construction_costs as occ')
            ->join('feasibility_study_components as fsc', 'occ.feasibility_study_component_id', '=', 'fsc.id')
            ->leftJoin('substation_rooms as sr', 'occ.substation_room_id', '=', 'sr.id')
            ->leftJoin('pumps_rooms as pr', 'occ.pumps_room_id', '=', 'pr.id')
            ->select(
                'occ.id',
                'occ.offer_id',
                'occ.feasibility_study_component_id',
                'occ.substation_room_id',
                'occ.pumps_room_id',
                'fsc.header_english as fsc_header_english',
                'fsc.header_arabic as fsc_header_arabic',
                'fsc.title_english as fsc_title_english',
                'fsc.title_arabic as fsc_title_arabic',
                'fsc.target as fsc_target',
                'sr.name_english as substation_name_english',
                'sr.name_arabic as substation_name_arabic',
                'sr.price as substation_price',
                'pr.name_english as pumps_name_english',
                'pr.name_arabic as pumps_name_arabic',
                'pr.price as pumps_price',
                'occ.created_at',
                'occ.updated_at'
            )
            ->where('occ.offer_id', $offerId)
            ->whereNull('occ.deleted_at')
            ->whereNull('fsc.deleted_at')
            ->orderBy('occ.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed construction costs for a specific offer
     */
    public static function getTrashedByOffer($offerId)
    {
        return DB::table('offer_construction_costs as occ')
            ->join('feasibility_study_components as fsc', 'occ.feasibility_study_component_id', '=', 'fsc.id')
            ->leftJoin('substation_rooms as sr', 'occ.substation_room_id', '=', 'sr.id')
            ->leftJoin('pumps_rooms as pr', 'occ.pumps_room_id', '=', 'pr.id')
            ->select(
                'occ.id',
                'occ.offer_id',
                'fsc.header_english as fsc_header_english',
                'sr.name_english as substation_name_english',
                'pr.name_english as pumps_name_english',
                'occ.deleted_at'
            )
            ->where('occ.offer_id', $offerId)
            ->whereNotNull('occ.deleted_at')
            ->orderBy('occ.deleted_at', 'desc')
            ->get();
    }
}

