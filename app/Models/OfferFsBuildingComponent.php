<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferFsBuildingComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_fs_building_components';
    protected $guarded = [];
    
    public function feasibilityStudy()
    {
        return $this->belongsTo(OfferFeasibilityStudy::class, 'offer_feasibility_study_id');
    }
    
    public function buildingComponent()
    {
        return $this->belongsTo(BuildingComponent::class, 'building_component_id');
    }
    
    public static function getByStudy($studyId)
    {
        return DB::table('offer_fs_building_components as ofbc')
            ->join('building_components as bc', 'ofbc.building_component_id', '=', 'bc.id')
            ->select(
                'ofbc.id',
                'ofbc.offer_feasibility_study_id',
                'ofbc.building_component_id',
                'ofbc.construction_cost',
                'bc.name_english',
                'bc.name_arabic',
                'bc.icon'
            )
            ->where('ofbc.offer_feasibility_study_id', $studyId)
            ->whereNull('ofbc.deleted_at')
            ->get();
    }
}

