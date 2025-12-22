<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferLengthComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_length_components';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Offer
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
    
    /**
     * Relationship: belongs to Building Component
     */
    public function buildingComponent()
    {
        return $this->belongsTo(BuildingComponent::class, 'building_component_id');
    }
    
    /**
     * Relationship: belongs to Length Component
     */
    public function lengthComponent()
    {
        return $this->belongsTo(LengthComponent::class, 'length_component_id');
    }
    
    /**
     * Get all length components for a specific offer
     */
    public static function getByOffer($offerId)
    {
        return DB::table('offer_length_components as olc')
            ->join('building_components as bc', 'olc.building_component_id', '=', 'bc.id')
            ->join('length_components as lc', 'olc.length_component_id', '=', 'lc.id')
            ->select(
                'olc.id',
                'olc.offer_id',
                'olc.building_component_id',
                'olc.length_component_id',
                'olc.unit_cost',
                'bc.name_english as building_component_name_english',
                'bc.name_arabic as building_component_name_arabic',
                'bc.icon as building_component_icon',
                'lc.name_english as length_component_name_english',
                'lc.name_arabic as length_component_name_arabic',
                'lc.icon as length_component_icon',
                'olc.created_at',
                'olc.updated_at'
            )
            ->where('olc.offer_id', $offerId)
            ->whereNull('olc.deleted_at')
            ->whereNull('bc.deleted_at')
            ->whereNull('lc.deleted_at')
            ->orderBy('olc.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed length components for a specific offer
     */
    public static function getTrashedByOffer($offerId)
    {
        return DB::table('offer_length_components as olc')
            ->join('building_components as bc', 'olc.building_component_id', '=', 'bc.id')
            ->join('length_components as lc', 'olc.length_component_id', '=', 'lc.id')
            ->select(
                'olc.id',
                'olc.offer_id',
                'olc.building_component_id',
                'olc.length_component_id',
                'olc.unit_cost',
                'bc.name_english as building_component_name_english',
                'lc.name_english as length_component_name_english',
                'olc.deleted_at'
            )
            ->where('olc.offer_id', $offerId)
            ->whereNotNull('olc.deleted_at')
            ->orderBy('olc.deleted_at', 'desc')
            ->get();
    }
}

