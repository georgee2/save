<?php

namespace App\Models\OffersPrices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Offer;
use App\Models\Emirate;

class OfferPrice extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_prices';
    protected $guarded = [];
    
    /**
     * Relationship: OfferPrice belongs to Offer
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
    
    /**
     * Relationship: OfferPrice belongs to Emirate
     */
    public function emirate()
    {
        return $this->belongsTo(Emirate::class, 'emirate_id');
    }
    
    /**
     * Get all prices for an offer
     */
    public static function getByOffer($offerId)
    {
        return DB::table('offer_prices as op')
            ->leftJoin('emirates as e', 'op.emirate_id', '=', 'e.id')
            ->select(
                'op.id',
                'op.offer_id',
                'op.emirate_id',
                'op.price',
                'op.notes_english',
                'op.notes_arabic',
                'op.status',
                'op.deleted_at',
                'op.created_at',
                'op.updated_at',
                'e.title_english as emirate_name_en',
                'e.title_arabic as emirate_name_ar'
            )
            ->where('op.offer_id', $offerId)
            ->whereNull('op.deleted_at')
            ->orderBy('e.title_english')
            ->get();
    }
    
    /**
     * Get trashed prices for an offer
     */
    public static function getTrashedByOffer($offerId)
    {
        return DB::table('offer_prices as op')
            ->leftJoin('emirates as e', 'op.emirate_id', '=', 'e.id')
            ->select(
                'op.id',
                'op.offer_id',
                'op.emirate_id',
                'op.price',
                'op.notes_english',
                'op.notes_arabic',
                'op.status',
                'op.deleted_at',
                'e.title_english as emirate_name_en',
                'e.title_arabic as emirate_name_ar'
            )
            ->where('op.offer_id', $offerId)
            ->whereNotNull('op.deleted_at')
            ->orderBy('op.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Get available emirates for an offer (not yet added)
     */
    public static function getAvailableEmirates($offerId)
    {
        $usedEmirateIds = DB::table('offer_prices')
            ->where('offer_id', $offerId)
            ->whereNull('deleted_at')
            ->pluck('emirate_id')
            ->toArray();
        
        return Emirate::whereNull('deleted_at')
            ->whereNotIn('id', $usedEmirateIds)
            ->orderBy('title_english')
            ->get(['id', 'title_english', 'title_arabic']);
    }
}

