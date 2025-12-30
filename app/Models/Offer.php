<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\OffersPrices\OfferPrice;

class Offer extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offers';
    protected $guarded = [];
    
    /**
     * Relationship: Offer belongs to Offer Category
     */
    public function category()
    {
        return $this->belongsTo(OfferCategory::class, 'category_id');
    }
    
    /**
     * Relationship: Offer belongs to Offer Sub Category
     */
    public function subcategory()
    {
        return $this->belongsTo(OfferSubCategory::class, 'subcategory_id');
    }
    
    /**
     * Relationship: Offer belongs to Currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    
    /**
     * Relationship: Offer belongs to Project Style
     */
    public function style()
    {
        return $this->belongsTo(ProjectStyle::class, 'style_id');
    }
    
    /**
     * Relationship: Offer belongs to Project Type
     */
    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'type_id');
    }
    
    /**
     * Relationship: Offer has many Prices
     */
    public function prices()
    {
        return $this->hasMany(OfferPrice::class, 'offer_id');
    }
    
    /**
     * Relationship: Offer has many Specifications
     */
    public function specifications()
    {
        return $this->hasMany(OfferSpecification::class, 'offer_id');
    }
    
    /**
     * Relationship: Offer has many Images
     */
    public function images()
    {
        return $this->hasMany(OfferImage::class, 'offer_id');
    }
    
    /**
     * Relationship: Offer has many Floors
     */
    public function floors()
    {
        return $this->hasMany(OfferFloor::class, 'offer_id');
    }
    
    /**
     * Relationship: Offer has many Feasibility Studies
     */
    public function feasibilityStudies()
    {
        return $this->hasMany(OfferFeasibilityStudy::class, 'offer_id');
    }
    
    /**
     * Get all offers for listing
     */
    public static function list()
    {
        return DB::table('offers as o')
            ->leftJoin('offer_categories as oc', 'o.category_id', '=', 'oc.id')
            ->leftJoin('project_types as pt', 'o.type_id', '=', 'pt.id')
            ->select(
                'o.id',
                'o.offer_code',
                'o.title_english',
                'o.title_arabic',
                'oc.title_english as category_name',
                'pt.name_english as type_name',
                'o.publish_status',
                'o.home_status',
                'o.created_at'
            )
            ->whereNull('o.deleted_at')
            ->orderBy('o.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed offers
     */
    public static function trashed()
    {
        return DB::table('offers as o')
            ->leftJoin('offer_categories as oc', 'o.category_id', '=', 'oc.id')
            ->leftJoin('project_types as pt', 'o.type_id', '=', 'pt.id')
            ->select(
                'o.id',
                'o.offer_code',
                'o.title_english',
                'o.title_arabic',
                'oc.title_english as category_name',
                'pt.name_english as type_name',
                'o.deleted_at'
            )
            ->whereNotNull('o.deleted_at')
            ->orderBy('o.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Generate a unique offer code based on category, subcategory, and ID.
     * Format: SKU-CATEGORY-SUBCATEGORY-ID (e.g., SKU-VIL-LUX-0001)
     *
     * @param int $offerId
     * @param int $categoryId
     * @param int|null $subcategoryId
     * @return string
     */
    public static function generateOfferCode(int $offerId, int $categoryId, ?int $subcategoryId = null): string
    {
        $category = OfferCategory::find($categoryId);
        $subcategory = $subcategoryId ? OfferSubCategory::find($subcategoryId) : null;

        $categoryCode = Str::upper(Str::substr($category->title_english ?? 'UNK', 0, 3));
        $subcategoryCode = $subcategory ? Str::upper(Str::substr($subcategory->title_english ?? 'UNK', 0, 3)) : 'NUL';

        return "SKU-{$categoryCode}-{$subcategoryCode}-" . str_pad($offerId, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Find offer with relationships
     */
    public static function findWithRelations($id)
    {
        return DB::table('offers as o')
            ->leftJoin('offer_categories as oc', 'o.category_id', '=', 'oc.id')
            ->leftJoin('offer_sub_categories as osc', 'o.subcategory_id', '=', 'osc.id')
            ->leftJoin('currencies as c', 'o.currency_id', '=', 'c.id')
            ->leftJoin('project_styles as ps', 'o.style_id', '=', 'ps.id')
            ->leftJoin('project_types as pt', 'o.type_id', '=', 'pt.id')
            ->select(
                'o.*',
                'oc.title_english as category_name_en',
                'oc.title_arabic as category_name_ar',
                'osc.title_english as subcategory_name_en',
                'osc.title_arabic as subcategory_name_ar',
                'c.name_english as currency_name_en',
                'c.abbreviation as currency_abbr',
                'ps.title_english as style_name_en',
                'ps.title_arabic as style_name_ar',
                'pt.name_english as type_name_en',
                'pt.name_arabic as type_name_ar'
            )
            ->where('o.id', $id)
            ->whereNull('o.deleted_at')
            ->first();
    }
}

