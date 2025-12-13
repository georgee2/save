<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Partner extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'partners';
    protected $guarded = [];
    
    /**
     * Get all partners for listing
     */
    public static function list()
    {
        return DB::table('partners')
            ->select('id', 'name_english', 'name_arabic', 'email', 'mobile', 'logo_english', 'logo_arabic', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed partners
     */
    public static function trashed()
    {
        return DB::table('partners')
            ->select('id', 'name_english', 'name_arabic', 'email', 'mobile', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
}

