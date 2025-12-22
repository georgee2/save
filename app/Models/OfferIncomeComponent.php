<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferIncomeComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_income_components';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Offer
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
    
    /**
     * Relationship: belongs to Income Component
     */
    public function incomeComponent()
    {
        return $this->belongsTo(IncomeComponent::class, 'income_component_id');
    }
    
    /**
     * Get all income components for a specific offer
     */
    public static function getByOffer($offerId)
    {
        return DB::table('offer_income_components as oic')
            ->join('income_components as ic', 'oic.income_component_id', '=', 'ic.id')
            ->select(
                'oic.id',
                'oic.offer_id',
                'oic.income_component_id',
                'oic.number_of_units',
                'oic.rent_per_year',
                'ic.name_english',
                'ic.name_arabic',
                'ic.icon',
                'oic.created_at',
                'oic.updated_at'
            )
            ->where('oic.offer_id', $offerId)
            ->whereNull('oic.deleted_at')
            ->whereNull('ic.deleted_at')
            ->orderBy('oic.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed income components for a specific offer
     */
    public static function getTrashedByOffer($offerId)
    {
        return DB::table('offer_income_components as oic')
            ->join('income_components as ic', 'oic.income_component_id', '=', 'ic.id')
            ->select(
                'oic.id',
                'oic.offer_id',
                'oic.income_component_id',
                'oic.number_of_units',
                'oic.rent_per_year',
                'ic.name_english',
                'ic.name_arabic',
                'oic.deleted_at'
            )
            ->where('oic.offer_id', $offerId)
            ->whereNotNull('oic.deleted_at')
            ->orderBy('oic.deleted_at', 'desc')
            ->get();
    }
}

