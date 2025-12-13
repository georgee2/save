<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class JobCategory extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'job_categories';
    protected $guarded = [];
    
    /**
     * Get all job categories for listing
     */
    public static function list()
    {
        return DB::table('job_categories')
            ->select('id', 'name_english', 'name_arabic', 'status', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed job categories
     */
    public static function trashed()
    {
        return DB::table('job_categories')
            ->select('id', 'name_english', 'name_arabic', 'status', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
}

