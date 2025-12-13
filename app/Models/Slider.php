<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Slider extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'sliders';
    protected $guarded = [];
    
    /**
     * Get all sliders for listing (ordered)
     */
    public static function list()
    {
        return DB::table('sliders')
            ->select(
                'id',
                'title_english',
                'title_arabic',
                'bio_english',
                'bio_arabic',
                'button_text_english',
                'button_text_arabic',
                'url_english',
                'url_arabic',
                'image',
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
     * Get trashed sliders
     */
    public static function trashed()
    {
        return DB::table('sliders')
            ->select(
                'id',
                'title_english',
                'title_arabic',
                'image',
                'ordering',
                'status',
                'deleted_at'
            )
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Get published sliders for frontend (ordered)
     */
    public static function published()
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
        return $this->status == 0 ? 'Published' : 'Not Published';
    }
    
    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status == 0 ? 'badge-success' : 'badge-danger';
    }
}

