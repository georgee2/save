<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Specification extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'specifications';
    protected $guarded = [];
    
    /**
     * Get all specifications for listing
     */
    public static function list()
    {
        return DB::table('specifications')
            ->leftJoin('project_types', 'specifications.type_id', '=', 'project_types.id')
            ->select(
                'specifications.id', 
                'specifications.title_english', 
                'specifications.title_arabic', 
                'specifications.icon', 
                'specifications.type_id',
                'specifications.status', 
                'specifications.created_at', 
                'specifications.updated_at',
                'project_types.name_english as type_name_english',
                'project_types.name_arabic as type_name_arabic'
            )
            ->whereNull('specifications.deleted_at')
            ->orderBy('specifications.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed specifications
     */
    public static function trashed()
    {
        return DB::table('specifications')
            ->select('id', 'title_english', 'title_arabic', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find specification by ID
     */
    public static function find($id)
    {
        return DB::table('specifications')
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
    
    /**
     * Relationship: Specification belongs to Project Type
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'type_id');
    }
}

