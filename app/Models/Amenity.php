<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Amenity extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'amenities';
    protected $guarded = [];
    
    /**
     * Get all amenities for listing
     */
    public static function list()
    {
        return DB::table('amenities')
            ->select('id', 'name_english', 'name_arabic', 'icon', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed amenities
     */
    public static function trashed()
    {
        return DB::table('amenities')
            ->select('id', 'name_english', 'name_arabic', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find amenity by ID
     */
    public static function find($id)
    {
        return DB::table('amenities')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

