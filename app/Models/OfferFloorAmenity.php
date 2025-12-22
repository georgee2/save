<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferFloorAmenity extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_floor_amenities';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Offer
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
    
    /**
     * Relationship: belongs to Offer Floor
     */
    public function floor()
    {
        return $this->belongsTo(OfferFloor::class, 'floor_id');
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
        return DB::table('offer_floor_amenities as ofa')
            ->join('amenities as a', 'ofa.amenity_id', '=', 'a.id')
            ->select(
                'ofa.id',
                'ofa.offer_id',
                'ofa.floor_id',
                'ofa.amenity_id',
                'a.name_english as amenity_name_en',
                'a.name_arabic as amenity_name_ar',
                'a.icon as amenity_icon',
                'ofa.created_at',
                'ofa.updated_at'
            )
            ->where('ofa.floor_id', $floorId)
            ->whereNull('ofa.deleted_at')
            ->whereNull('a.deleted_at')
            ->orderBy('ofa.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed amenities for a specific floor
     */
    public static function getTrashedByFloor($floorId)
    {
        return DB::table('offer_floor_amenities as ofa')
            ->join('amenities as a', 'ofa.amenity_id', '=', 'a.id')
            ->select(
                'ofa.id',
                'ofa.floor_id',
                'ofa.amenity_id',
                'a.name_english as amenity_name_en',
                'a.name_arabic as amenity_name_ar',
                'ofa.deleted_at'
            )
            ->where('ofa.floor_id', $floorId)
            ->whereNotNull('ofa.deleted_at')
            ->orderBy('ofa.deleted_at', 'desc')
            ->get();
    }
}

