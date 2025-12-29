<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferFloor extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_floors';
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
     * Relationship: belongs to Floor Component
     */
    public function floorComponent()
    {
        return $this->belongsTo(FloorComponent::class, 'floor_component_id');
    }
    
    /**
     * Relationship: Floor has many Specifications
     */
    public function specifications()
    {
        return $this->hasMany(OfferFloorSpecification::class, 'floor_id');
    }
    
    /**
     * Relationship: Floor has many Amenities
     */
    public function amenities()
    {
        return $this->hasMany(OfferFloorAmenity::class, 'floor_id');
    }
    
    /**
     * Get all floors for a specific offer
     */
    public static function getByOffer($offerId)
    {
        return DB::table('offer_floors as of')
            ->join('building_components as bc', 'of.building_component_id', '=', 'bc.id')
            ->join('floor_components as fc', 'of.floor_component_id', '=', 'fc.id')
            ->select(
                'of.id',
                'of.offer_id',
                'of.building_component_id',
                'of.floor_component_id',
                'of.sqft',
                'of.sqm',
                'of.count',
                'of.image_2d',
                'of.image_3d',
                'bc.name_english as building_component_name_en',
                'bc.name_arabic as building_component_name_ar',
                'bc.icon as building_component_icon',
                'fc.name_english as floor_component_name_en',
                'fc.name_arabic as floor_component_name_ar',
                'fc.icon as floor_component_icon',
                'of.created_at',
                'of.updated_at'
            )
            ->where('of.offer_id', $offerId)
            ->whereNull('of.deleted_at')
            ->whereNull('bc.deleted_at')
            ->whereNull('fc.deleted_at')
            ->orderBy('of.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed floors for a specific offer
     */
    public static function getTrashedByOffer($offerId)
    {
        return DB::table('offer_floors as of')
            ->join('building_components as bc', 'of.building_component_id', '=', 'bc.id')
            ->join('floor_components as fc', 'of.floor_component_id', '=', 'fc.id')
            ->select(
                'of.id',
                'of.offer_id',
                'of.building_component_id',
                'of.floor_component_id',
                'of.sqft',
                'of.sqm',
                'of.count',
                'bc.name_english as building_component_name_en',
                'bc.name_arabic as building_component_name_ar',
                'fc.name_english as floor_component_name_en',
                'fc.name_arabic as floor_component_name_ar',
                'of.deleted_at'
            )
            ->where('of.offer_id', $offerId)
            ->whereNotNull('of.deleted_at')
            ->orderBy('of.deleted_at', 'desc')
            ->get();
    }
}

