<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FsProjectCost extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'fs_project_costs';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Feasibility Study
     */
    public function feasibilityStudy()
    {
        return $this->belongsTo(FeasibilityStudy::class, 'feasibility_study_id');
    }
    
    /**
     * Get project cost for a specific study
     */
    public static function getByStudy($studyId)
    {
        return DB::table('fs_project_costs')
            ->where('feasibility_study_id', $studyId)
            ->whereNull('deleted_at')
            ->first();
    }
    
    /**
     * Calculate total additional costs (excluding construction)
     */
    public function calculateAdditionalCosts()
    {
        return $this->land_cost + $this->consultant_cost + $this->government_fees + $this->additional_fees;
    }
    
    /**
     * Calculate total project cost including construction
     */
    public function calculateTotalProjectCost($constructionCost)
    {
        return $constructionCost + $this->calculateAdditionalCosts();
    }
}

