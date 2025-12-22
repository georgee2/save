<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferFloorSpecification extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_floor_specifications';
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
     * Relationship: belongs to Specification
     */
    public function specification()
    {
        return $this->belongsTo(Specification::class, 'specification_id');
    }
    
    /**
     * Get all specifications for a specific floor
     */
    public static function getByFloor($floorId)
    {
        return DB::table('offer_floor_specifications as ofs')
            ->join('specifications as s', 'ofs.specification_id', '=', 's.id')
            ->select(
                'ofs.id',
                'ofs.offer_id',
                'ofs.floor_id',
                'ofs.specification_id',
                'ofs.value_english',
                'ofs.value_arabic',
                's.title_english as specification_title_en',
                's.title_arabic as specification_title_ar',
                's.icon as specification_icon',
                'ofs.created_at',
                'ofs.updated_at'
            )
            ->where('ofs.floor_id', $floorId)
            ->whereNull('ofs.deleted_at')
            ->whereNull('s.deleted_at')
            ->orderBy('ofs.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed specifications for a specific floor
     */
    public static function getTrashedByFloor($floorId)
    {
        return DB::table('offer_floor_specifications as ofs')
            ->join('specifications as s', 'ofs.specification_id', '=', 's.id')
            ->select(
                'ofs.id',
                'ofs.floor_id',
                'ofs.specification_id',
                'ofs.value_english',
                'ofs.value_arabic',
                's.title_english as specification_title_en',
                's.title_arabic as specification_title_ar',
                'ofs.deleted_at'
            )
            ->where('ofs.floor_id', $floorId)
            ->whereNotNull('ofs.deleted_at')
            ->orderBy('ofs.deleted_at', 'desc')
            ->get();
    }
}

