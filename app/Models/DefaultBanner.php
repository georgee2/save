<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DefaultBanner extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'default_banners';
    protected $guarded = [];
    
    /**
     * Get all default banners for listing
     */
    public static function list()
    {
        return DB::table('default_banners')
            ->select(
                'id',
                'title_english',
                'title_arabic',
                'background',
                'status',
                'created_at',
                'updated_at'
            )
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed default banners
     */
    public static function trashed()
    {
        return DB::table('default_banners')
            ->select(
                'id',
                'title_english',
                'title_arabic',
                'background',
                'status',
                'deleted_at'
            )
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Get active default banner for frontend (most recent)
     */
    public static function active()
    {
        return self::where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
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

