<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FsIncomeComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'fs_income_components';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Feasibility Study
     */
    public function feasibilityStudy()
    {
        return $this->belongsTo(FeasibilityStudy::class, 'feasibility_study_id');
    }
    
    /**
     * Relationship: belongs to Income Component
     */
    public function incomeComponent()
    {
        return $this->belongsTo(IncomeComponent::class, 'income_component_id');
    }
    
    /**
     * Get all income components for a specific study
     */
    public static function getByStudy($studyId)
    {
        return DB::table('fs_income_components as fsic')
            ->join('income_components as ic', 'fsic.income_component_id', '=', 'ic.id')
            ->select(
                'fsic.id',
                'fsic.feasibility_study_id',
                'fsic.income_component_id',
                'fsic.number_of_units',
                'fsic.rent_per_year',
                'ic.name_english',
                'ic.name_arabic',
                'ic.icon',
                'fsic.created_at',
                'fsic.updated_at'
            )
            ->where('fsic.feasibility_study_id', $studyId)
            ->whereNull('fsic.deleted_at')
            ->whereNull('ic.deleted_at')
            ->orderBy('fsic.created_at', 'desc')
            ->get();
    }
    
    /**
     * Calculate total income for a component
     */
    public function calculateTotal()
    {
        return $this->number_of_units * $this->rent_per_year;
    }
}

