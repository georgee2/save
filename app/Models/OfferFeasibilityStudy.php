<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferFeasibilityStudy extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_feasibility_studies';
    protected $guarded = [];
    
    /**
     * Relationship: Feasibility Study belongs to Offer
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
    
    /**
     * Relationship: Feasibility Study belongs to User (creator)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Relationship: Feasibility Study belongs to Currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    
    /**
     * Relationship: Feasibility Study belongs to Emirate
     */
    public function emirate()
    {
        return $this->belongsTo(Emirate::class, 'emirate_id');
    }
    
    /**
     * Relationship: has many Building Components
     */
    public function buildingComponents()
    {
        return $this->hasMany(OfferFsBuildingComponent::class, 'offer_feasibility_study_id');
    }
    
    /**
     * Relationship: has many Length Components
     */
    public function lengthComponents()
    {
        return $this->hasMany(OfferFsLengthComponent::class, 'offer_feasibility_study_id');
    }
    
    /**
     * Relationship: has many Income Components
     */
    public function incomeComponents()
    {
        return $this->hasMany(OfferFsIncomeComponent::class, 'offer_feasibility_study_id');
    }
    
    /**
     * Relationship: has many Construction Costs
     */
    public function constructionCosts()
    {
        return $this->hasMany(OfferFsConstructionCost::class, 'offer_feasibility_study_id');
    }
    
    /**
     * Relationship: has one Project Cost
     */
    public function projectCost()
    {
        return $this->hasOne(OfferFsProjectCost::class, 'offer_feasibility_study_id');
    }
    
    /**
     * Get all feasibility studies for listing
     */
    public static function list()
    {
        return DB::table('offer_feasibility_studies as ofs')
            ->join('offers as o', 'ofs.offer_id', '=', 'o.id')
            ->join('emirates as e', 'ofs.emirate_id', '=', 'e.id')
            ->leftJoin('users as u', 'ofs.created_by', '=', 'u.id')
            ->leftJoin('offer_prices as op', function($join) {
                $join->on('op.offer_id', '=', 'ofs.offer_id')
                     ->on('op.emirate_id', '=', 'ofs.emirate_id')
                     ->whereNull('op.deleted_at');
            })
            ->select(
                'ofs.id',
                'ofs.study_name',
                'ofs.study_type',
                'ofs.status',
                'ofs.description',
                'o.title_english as offer_name',
                'o.id as offer_id',
                'e.title_english as emirate_name_en',
                'e.title_arabic as emirate_name_ar',
                'op.price as emirate_price',
                'u.name as creator_name',
                'ofs.created_at',
                'ofs.updated_at'
            )
            ->whereNull('ofs.deleted_at')
            ->whereNull('o.deleted_at')
            ->orderBy('ofs.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get all studies for a specific offer
     */
    public static function getByOffer($offerId)
    {
        return DB::table('offer_feasibility_studies as ofs')
            ->leftJoin('users as u', 'ofs.created_by', '=', 'u.id')
            ->join('emirates as e', 'ofs.emirate_id', '=', 'e.id')
            ->leftJoin('offer_prices as op', function($join) {
                $join->on('op.offer_id', '=', 'ofs.offer_id')
                     ->on('op.emirate_id', '=', 'ofs.emirate_id')
                     ->whereNull('op.deleted_at');
            })
            ->select(
                'ofs.id',
                'ofs.study_name',
                'ofs.study_type',
                'ofs.status',
                'ofs.description',
                'u.name as creator_name',
                'e.title_english as emirate_name_en',
                'e.title_arabic as emirate_name_ar',
                'op.price as emirate_price',
                'ofs.created_at',
                'ofs.updated_at'
            )
            ->where('ofs.offer_id', $offerId)
            ->whereNull('ofs.deleted_at')
            ->orderBy('ofs.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed feasibility studies
     */
    public static function trashed()
    {
        return DB::table('offer_feasibility_studies as ofs')
            ->join('offers as o', 'ofs.offer_id', '=', 'o.id')
            ->select(
                'ofs.id',
                'ofs.study_name',
                'ofs.study_type',
                'o.title_english as offer_name',
                'ofs.deleted_at'
            )
            ->whereNotNull('ofs.deleted_at')
            ->orderBy('ofs.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find feasibility study with relationships
     */
    public static function findWithRelations($id)
    {
        return DB::table('offer_feasibility_studies as ofs')
            ->join('offers as o', 'ofs.offer_id', '=', 'o.id')
            ->join('emirates as e', 'ofs.emirate_id', '=', 'e.id')
            ->leftJoin('users as u', 'ofs.created_by', '=', 'u.id')
            ->leftJoin('currencies as c', 'ofs.currency_id', '=', 'c.id')
            ->leftJoin('offer_prices as op', function($join) {
                $join->on('op.offer_id', '=', 'ofs.offer_id')
                     ->on('op.emirate_id', '=', 'ofs.emirate_id')
                     ->whereNull('op.deleted_at');
            })
            ->select(
                'ofs.*',
                'o.title_english as offer_name_en',
                'o.title_arabic as offer_name_ar',
                'o.type_id as offer_type_id',
                'u.name as creator_name',
                'c.name_english as currency_name',
                'c.abbreviation as currency_abbreviation',
                'e.title_english as emirate_name_en',
                'e.title_arabic as emirate_name_ar',
                'op.price as emirate_price'
            )
            ->where('ofs.id', $id)
            ->whereNull('ofs.deleted_at')
            ->first();
    }
    
    /**
     * Check if study is master type
     */
    public function isMaster()
    {
        return $this->study_type === 'Master';
    }
    
    /**
     * Check if study is custom type
     */
    public function isCustom()
    {
        return $this->study_type === 'Custom';
    }
    
    /**
     * Check if study is active
     */
    public function isActive()
    {
        return $this->status === 'Active';
    }
}

