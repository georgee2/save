<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferSpecification extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_specifications';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Offer
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
    
    /**
     * Relationship: belongs to Specification
     */
    public function specification()
    {
        return $this->belongsTo(Specification::class, 'specification_id');
    }
    
    /**
     * Get all specifications for a specific offer
     */
    public static function getByOffer($offerId)
    {
        return DB::table('offer_specifications as os')
            ->join('specifications as s', 'os.specification_id', '=', 's.id')
            ->select(
                'os.id',
                'os.offer_id',
                'os.specification_id',
                'os.value_english',
                'os.value_arabic',
                's.title_english',
                's.title_arabic',
                's.icon',
                'os.created_at',
                'os.updated_at'
            )
            ->where('os.offer_id', $offerId)
            ->whereNull('os.deleted_at')
            ->whereNull('s.deleted_at')
            ->orderBy('os.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed specifications for a specific offer
     */
    public static function getTrashedByOffer($offerId)
    {
        return DB::table('offer_specifications as os')
            ->join('specifications as s', 'os.specification_id', '=', 's.id')
            ->select(
                'os.id',
                'os.offer_id',
                'os.specification_id',
                'os.value_english',
                'os.value_arabic',
                's.title_english',
                's.title_arabic',
                'os.deleted_at'
            )
            ->where('os.offer_id', $offerId)
            ->whereNotNull('os.deleted_at')
            ->orderBy('os.deleted_at', 'desc')
            ->get();
    }
}

