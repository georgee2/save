<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Fact extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'facts';
    protected $guarded = [];
    
    /**
     * Get all facts for listing (ordered)
     */
    public static function list()
    {
        return DB::table('facts')
            ->select(
                'id',
                'title_english',
                'title_arabic',
                'icon',
                'fact_number',
                'ordering',
                'status',
                'created_at',
                'updated_at'
            )
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed facts
     */
    public static function trashed()
    {
        return DB::table('facts')
            ->select(
                'id',
                'title_english',
                'title_arabic',
                'icon',
                'fact_number',
                'ordering',
                'status',
                'deleted_at'
            )
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Get active facts for frontend (ordered)
     */
    public static function active()
    {
        return self::where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
    }
    
    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return $this->status == 0 ? 'Active' : 'Not Active';
    }
    
    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status == 0 ? 'badge-success' : 'badge-danger';
    }
}

