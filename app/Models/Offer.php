<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\OffersPrices\OfferPrice;
use App\Traits\LogsActivity;

class Offer extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $logTitleField = 'title_english';
    
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
                'o.offer_number',
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
                'o.offer_number',
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
     * Generate a unique offer code based on category abbreviation, subcategory abbreviation, and offer number.
     * Format: CATEGORY-SUBCATEGORY-NUMBER (e.g., VIL-LUX-001)
     *
     * @param int $categoryId
     * @param int|null $subcategoryId
     * @param string|null $offerNumber
     * @return string
     */
    public static function generateOfferCode($categoryId, $subcategoryId = null, $offerNumber = null)
    {
        $codeParts = [];

        // Get category abbreviation (first 3 characters uppercase)
        if ($categoryId) {
            $category = OfferCategory::find($categoryId);
            if ($category) {
                $codeParts[] = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $category->title_english), 0, 3));
            }
        }

        // Get subcategory abbreviation (first 3 characters uppercase)
        if ($subcategoryId) {
            $subcategory = OfferSubCategory::find($subcategoryId);
            if ($subcategory) {
                $codeParts[] = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $subcategory->title_english), 0, 3));
            }
        }

        // Add offer number if available
        if ($offerNumber) {
            $codeParts[] = $offerNumber;
        }

        return implode('-', $codeParts);
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

