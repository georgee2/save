<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferFsIncomeComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_fs_income_components';
    protected $guarded = [];
    
    public function feasibilityStudy()
    {
        return $this->belongsTo(OfferFeasibilityStudy::class, 'offer_feasibility_study_id');
    }
    
    public function incomeComponent()
    {
        return $this->belongsTo(IncomeComponent::class, 'income_component_id');
    }
    
    public static function getByStudy($studyId)
    {
        return DB::table('offer_fs_income_components as ofic')
            ->join('income_components as ic', 'ofic.income_component_id', '=', 'ic.id')
            ->select(
                'ofic.id',
                'ofic.offer_feasibility_study_id',
                'ofic.income_component_id',
                'ofic.number_of_units',
                'ofic.rent_per_year',
                'ic.name_english',
                'ic.name_arabic',
                'ic.icon'
            )
            ->where('ofic.offer_feasibility_study_id', $studyId)
            ->whereNull('ofic.deleted_at')
            ->get();
    }
}

