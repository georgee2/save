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
            ->select('id', 'name_english', 'name_arabic', 'is_board_director', 'created_at', 'updated_at')
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
            ->select('id', 'name_english', 'name_arabic', 'is_board_director', 'deleted_at')
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
    
    /**
     * Get board director ranks
     */
    public static function getBoardDirectors()
    {
        return DB::table('ranks')
            ->select('id', 'name_english', 'name_arabic')
            ->where('is_board_director', true)
            ->whereNull('deleted_at')
            ->orderBy('name_english', 'asc')
            ->get();
    }
}

