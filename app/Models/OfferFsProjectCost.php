<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OfferFsProjectCost extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'offer_fs_project_costs';
    protected $guarded = [];
    
    public function feasibilityStudy()
    {
        return $this->belongsTo(OfferFeasibilityStudy::class, 'offer_feasibility_study_id');
    }
    
    public static function getByStudy($studyId)
    {
        return DB::table('offer_fs_project_costs')
            ->where('offer_feasibility_study_id', $studyId)
            ->whereNull('deleted_at')
            ->first();
    }
}

