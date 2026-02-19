<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $logTitleField = 'title_english';
    
    protected $table = 'projects';
    protected $guarded = [];
    
    /**
     * Relationship: Project belongs to Engineering Category
     */
    public function category()
    {
        return $this->belongsTo(EngineeringCategory::class, 'category_id');
    }
    
    /**
     * Relationship: Project belongs to Engineering Sub Category
     */
    public function subcategory()
    {
        return $this->belongsTo(EngineeringSubCategory::class, 'subcategory_id');
    }
    
    /**
     * Relationship: Project belongs to Currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    
    /**
     * Relationship: Project belongs to Project Style
     */
    public function style()
    {
        return $this->belongsTo(ProjectStyle::class, 'style_id');
    }
    
    /**
     * Relationship: Project belongs to Project Type
     */
    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'type_id');
    }
    
    /**
     * Relationship: Project belongs to Partner
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }
    
    /**
     * Relationship: Project belongs to Emirate
     */
    public function emirate()
    {
        return $this->belongsTo(Emirate::class, 'emirate_id');
    }
    
    /**
     * Relationship: Project has many Floors
     */
    public function floors()
    {
        return $this->hasMany(ProjectFloor::class, 'project_id');
    }
    
    /**
     * Relationship: Project has many Income Components
     */
    public function incomeComponents()
    {
        return $this->hasMany(ProjectIncomeComponent::class, 'project_id');
    }
    
    /**
     * Relationship: Project has many Length Components
     */
    public function lengthComponents()
    {
        return $this->hasMany(ProjectLengthComponent::class, 'project_id');
    }
    
    /**
     * Relationship: Project has many Specifications
     */
    public function specifications()
    {
        return $this->hasMany(ProjectSpecification::class, 'project_id');
    }
    
    /**
     * Relationship: Project has many Construction Costs
     */
    public function constructionCosts()
    {
        return $this->hasMany(ProjectConstructionCost::class, 'project_id');
    }
    
    /**
     * Relationship: Project has many Feasibility Studies
     */
    public function feasibilityStudies()
    {
        return $this->hasMany(FeasibilityStudy::class, 'project_id');
    }
    
    /**
     * Relationship: Project has many Images
     */
    public function images()
    {
        return $this->hasMany(ProjectImage::class, 'project_id');
    }
    
    /**
     * Get all projects for listing
     */
    public static function list()
    {
        return DB::table('projects as p')
            ->leftJoin('engineering_categories as ec', 'p.category_id', '=', 'ec.id')
            ->leftJoin('project_types as pt', 'p.type_id', '=', 'pt.id')
            ->select(
                'p.id',
                'p.project_code',
                'p.project_number',
                'p.title_english',
                'p.title_arabic',
                'ec.title_english as category_name',
                'pt.name_english as type_name',
                'p.publish_status',
                'p.home_status',
                'p.created_at'
            )
            ->whereNull('p.deleted_at')
            ->orderBy('p.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed projects
     */
    public static function trashed()
    {
        return DB::table('projects as p')
            ->leftJoin('engineering_categories as ec', 'p.category_id', '=', 'ec.id')
            ->leftJoin('project_types as pt', 'p.type_id', '=', 'pt.id')
            ->select(
                'p.id',
                'p.project_code',
                'p.project_number',
                'p.title_english',
                'p.title_arabic',
                'ec.title_english as category_name',
                'pt.name_english as type_name',
                'p.deleted_at'
            )
            ->whereNotNull('p.deleted_at')
            ->orderBy('p.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find project with relationships
     */
    public static function findWithRelations($id)
    {
        return DB::table('projects as p')
            ->leftJoin('engineering_categories as ec', 'p.category_id', '=', 'ec.id')
            ->leftJoin('engineering_sub_categories as esc', 'p.subcategory_id', '=', 'esc.id')
            ->leftJoin('currencies as c', 'p.currency_id', '=', 'c.id')
            ->leftJoin('project_styles as ps', 'p.style_id', '=', 'ps.id')
            ->leftJoin('project_types as pt', 'p.type_id', '=', 'pt.id')
            ->leftJoin('partners as pa', 'p.partner_id', '=', 'pa.id')
            ->leftJoin('emirates as em', 'p.emirate_id', '=', 'em.id')
            ->select(
                'p.*',
                'ec.title_english as category_name_en',
                'ec.title_arabic as category_name_ar',
                'esc.title_english as subcategory_name_en',
                'esc.title_arabic as subcategory_name_ar',
                'c.name_english as currency_name_en',
                'c.abbreviation as currency_abbr',
                'ps.title_english as style_name_en',
                'ps.title_arabic as style_name_ar',
                'pt.name_english as type_name_en',
                'pt.name_arabic as type_name_ar',
                'pa.name_english as partner_name_en',
                'pa.name_arabic as partner_name_ar',
                'em.title_english as emirate_name_en',
                'em.title_arabic as emirate_name_ar'
            )
            ->where('p.id', $id)
            ->whereNull('p.deleted_at')
            ->first();
    }
    
    /**
     * Generate project code: CATEGORY_ABBR + SUBCATEGORY_ABBR + PROJECT_NUMBER
     * Format: CAT-SUBCAT-PROJNUM (e.g., VIL-LUX-001)
     */
    public static function generateProjectCode($categoryId, $subcategoryId, $projectNumber)
    {
        $parts = [];
        
        // Get category abbreviation (first 3 characters uppercase)
        if ($categoryId) {
            $category = EngineeringCategory::find($categoryId);
            if ($category) {
                $parts[] = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $category->title_english), 0, 3));
            }
        }
        
        // Get subcategory abbreviation (first 3 characters uppercase)
        if ($subcategoryId) {
            $subcategory = EngineeringSubCategory::find($subcategoryId);
            if ($subcategory) {
                $parts[] = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $subcategory->title_english), 0, 3));
            }
        }
        
        // Add project number if provided
        if ($projectNumber) {
            $parts[] = $projectNumber;
        }
        
        // Join parts with dash
        return implode('-', $parts);
    }
}

