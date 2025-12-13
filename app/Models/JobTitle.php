<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class JobTitle extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'job_titles';
    protected $guarded = [];
    
    /**
     * Get all job titles for listing
     */
    public static function list()
    {
        return DB::table('job_titles')
            ->select('id', 'name_english', 'name_arabic', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed job titles
     */
    public static function trashed()
    {
        return DB::table('job_titles')
            ->select('id', 'name_english', 'name_arabic', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find job title by ID
     */
    public static function find($id)
    {
        return DB::table('job_titles')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

