<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferBuildingComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_building_components';
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
     * Get all building components for a specific offer
     */
    public static function getByOffer($offerId)
    {
        return DB::table('offer_building_components as obc')
            ->join('building_components as bc', 'obc.building_component_id', '=', 'bc.id')
            ->select(
                'obc.id',
                'obc.offer_id',
                'obc.building_component_id',
                'obc.construction_cost',
                'bc.name_english',
                'bc.name_arabic',
                'bc.icon',
                'obc.created_at',
                'obc.updated_at'
            )
            ->where('obc.offer_id', $offerId)
            ->whereNull('obc.deleted_at')
            ->whereNull('bc.deleted_at')
            ->orderBy('obc.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed building components for a specific offer
     */
    public static function getTrashedByOffer($offerId)
    {
        return DB::table('offer_building_components as obc')
            ->join('building_components as bc', 'obc.building_component_id', '=', 'bc.id')
            ->select(
                'obc.id',
                'obc.offer_id',
                'obc.building_component_id',
                'obc.construction_cost',
                'bc.name_english',
                'bc.name_arabic',
                'obc.deleted_at'
            )
            ->where('obc.offer_id', $offerId)
            ->whereNotNull('obc.deleted_at')
            ->orderBy('obc.deleted_at', 'desc')
            ->get();
    }
}

