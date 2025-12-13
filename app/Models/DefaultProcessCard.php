<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DefaultProcessCard extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'default_process_cards';
    protected $guarded = [];
    
    /**
     * Relationship: Card belongs to DefaultProcess
     */
    public function defaultProcess()
    {
        return $this->belongsTo(DefaultProcess::class, 'default_process_id');
    }
    
    /**
     * Get all cards for a specific process
     */
    public static function listByProcess($processId)
    {
        return DB::table('default_process_cards')
            ->select(
                'id',
                'default_process_id',
                'title_english',
                'title_arabic',
                'bio_english',
                'bio_arabic',
                'ordering',
                'status',
                'created_at',
                'updated_at'
            )
            ->where('default_process_id', $processId)
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
    }
    
    /**
     * Get trashed cards for a specific process
     */
    public static function trashedByProcess($processId)
    {
        return DB::table('default_process_cards')
            ->select(
                'id',
                'default_process_id',
                'title_english',
                'title_arabic',
                'ordering',
                'status',
                'deleted_at'
            )
            ->where('default_process_id', $processId)
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

