<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsActivity;

class Slider extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $logTitleField = 'title_english';
    
    protected $table = 'sliders';
    protected $guarded = [];
    
    /**
     * Relationship: belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    /**
     * Relationship: belongs to Offer
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
    
    /**
     * Get all sliders for listing (ordered)
     */
    public static function list()
    {
        return DB::table('sliders')
            ->select(
                'id',
                'slider_type',
                'project_id',
                'offer_id',
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
                'slider_type',
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
     * Get published sliders for frontend (ordered) with relationships
     */
    public static function published()
    {
        return self::with(['project.category', 'project.subcategory', 'project.specifications.specification', 
                          'offer.category', 'offer.subcategory', 'offer.currency', 'offer.specifications.specification'])
            ->where('status', 0)
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
    
    /**
     * Get slider type label
     */
    public function getTypeLabelAttribute()
    {
        $labels = [
            'default' => 'Default',
            'project' => 'Project',
            'offer' => 'Offer'
        ];
        return $labels[$this->slider_type] ?? 'Default';
    }
    
    /**
     * Get slider type badge class
     */
    public function getTypeBadgeAttribute()
    {
        $badges = [
            'default' => 'badge-primary',
            'project' => 'badge-success',
            'offer' => 'badge-warning'
        ];
        return $badges[$this->slider_type] ?? 'badge-secondary';
    }
}
