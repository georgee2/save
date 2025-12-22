<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferFsLengthComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_fs_length_components';
    protected $guarded = [];
    
    public function feasibilityStudy()
    {
        return $this->belongsTo(OfferFeasibilityStudy::class, 'offer_feasibility_study_id');
    }
    
    public function buildingComponent()
    {
        return $this->belongsTo(BuildingComponent::class, 'building_component_id');
    }
    
    public function lengthComponent()
    {
        return $this->belongsTo(LengthComponent::class, 'length_component_id');
    }
    
    public static function getByStudy($studyId)
    {
        return DB::table('offer_fs_length_components as oflc')
            ->join('building_components as bc', 'oflc.building_component_id', '=', 'bc.id')
            ->join('length_components as lc', 'oflc.length_component_id', '=', 'lc.id')
            ->select(
                'oflc.id',
                'oflc.offer_feasibility_study_id',
                'oflc.building_component_id',
                'oflc.length_component_id',
                'oflc.unit_cost',
                'bc.name_english as building_name_en',
                'bc.name_arabic as building_name_ar',
                'lc.name_english as length_name_en',
                'lc.name_arabic as length_name_ar',
                'lc.icon'
            )
            ->where('oflc.offer_feasibility_study_id', $studyId)
            ->whereNull('oflc.deleted_at')
            ->get();
    }
}

