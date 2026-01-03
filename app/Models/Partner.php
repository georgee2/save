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
            ->select('id', 'partner_type', 'display_order', 'name_english', 'name_arabic', 'email', 'mobile', 'logo_english', 'logo_arabic', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('partner_type', 'asc')
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed partners
     */
    public static function trashed()
    {
        return DB::table('partners')
            ->select('id', 'partner_type', 'name_english', 'name_arabic', 'email', 'mobile', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Get only partners (not branches) ordered
     */
    public static function getPartners()
    {
        return self::where('partner_type', 'partner')
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get only branches ordered
     */
    public static function getBranches()
    {
        return self::where('partner_type', 'branch')
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get only government partners ordered
     */
    public static function getGovernmentPartners()
    {
        return self::where('partner_type', 'government')
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

