<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DefaultProcess extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'default_processes';
    protected $guarded = [];
    
    /**
     * Relationship: DefaultProcess has many cards
     */
    public function cards()
    {
        return $this->hasMany(DefaultProcessCard::class, 'default_process_id');
    }
    
    /**
     * Get active cards ordered by ordering
     */
    public function activeCards()
    {
        return $this->hasMany(DefaultProcessCard::class, 'default_process_id')
            ->where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc');
    }
    
    /**
     * Get all default processes for listing
     */
    public static function list()
    {
        return DB::table('default_processes')
            ->select(
                'id',
                'title_english',
                'title_arabic',
                'sub_title_english',
                'sub_title_arabic',
                'bio_english',
                'bio_arabic',
                'button_text_english',
                'button_text_arabic',
                'url_english',
                'url_arabic',
                'status',
                'created_at',
                'updated_at'
            )
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed default processes
     */
    public static function trashed()
    {
        return DB::table('default_processes')
            ->select(
                'id',
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
     * Get active default process for frontend
     */
    public static function active()
    {
        return self::where('status', 0)
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

