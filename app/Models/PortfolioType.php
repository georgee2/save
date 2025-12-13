<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PortfolioType extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'portfolio_types';
    protected $guarded = [];
    
    /**
     * Get all portfolio types for listing
     */
    public static function list()
    {
        return DB::table('portfolio_types')
            ->select('id', 'name_english', 'name_arabic', 'status', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed portfolio types
     */
    public static function trashed()
    {
        return DB::table('portfolio_types')
            ->select('id', 'name_english', 'name_arabic', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find portfolio type by ID
     */
    public static function find($id)
    {
        return DB::table('portfolio_types')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
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

