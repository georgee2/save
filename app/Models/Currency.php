<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Currency extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'currencies';
    protected $guarded = [];
    
    /**
     * Get all currencies for listing
     */
    public static function list()
    {
        return DB::table('currencies')
            ->select('id', 'name_english', 'name_arabic', 'abbreviation', 'status', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed currencies
     */
    public static function trashed()
    {
        return DB::table('currencies')
            ->select('id', 'name_english', 'name_arabic', 'abbreviation', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
}

