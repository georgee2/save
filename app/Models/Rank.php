<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Rank extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'ranks';
    protected $guarded = [];
    
    /**
     * Get all ranks for listing
     */
    public static function list()
    {
        return DB::table('ranks')
            ->select('id', 'name_english', 'name_arabic', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed ranks
     */
    public static function trashed()
    {
        return DB::table('ranks')
            ->select('id', 'name_english', 'name_arabic', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find rank by ID
     */
    public static function find($id)
    {
        return DB::table('ranks')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

