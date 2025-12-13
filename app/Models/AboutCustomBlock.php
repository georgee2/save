<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class AboutCustomBlock extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'about_custom_blocks';
    protected $guarded = [];
    
    /**
     * Get all active blocks
     */
    public static function getActive()
    {
        return self::where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get all blocks for listing
     */
    public static function list()
    {
        return DB::table('about_custom_blocks')
            ->select(
                'id',
                'image',
                'title_english',
                'title_arabic',
                'description_english',
                'description_arabic',
                'status',
                'created_at',
                'updated_at'
            )
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed blocks
     */
    public static function trashed()
    {
        return DB::table('about_custom_blocks')
            ->select(
                'id',
                'image',
                'title_english',
                'title_arabic',
                'status',
                'deleted_at'
            )
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
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

