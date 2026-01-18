<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PageBanner extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'page_banners';
    protected $guarded = [];
    
    /**
     * Available target pages
     */
    public static function getTargetPages()
    {
        return [
            'services' => 'Services',
            'portfolios' => 'Portfolios',
            'projects' => 'Projects',
            'offers' => 'Offers',
            'showcases' => 'Showcases',
            'blogs' => 'Blogs',
            'careers' => 'Careers',
            'team' => 'Team',
            'contact' => 'Contact',
        ];
    }
    
    /**
     * Get all page banners for listing
     */
    public static function list()
    {
        return DB::table('page_banners')
            ->select('id', 'target', 'cover', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed page banners
     */
    public static function trashed()
    {
        return DB::table('page_banners')
            ->select('id', 'target', 'cover', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find page banner by ID
     */
    public static function find($id)
    {
        return DB::table('page_banners')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
    
    /**
     * Get banner by target page
     */
    public static function getByTarget($target)
    {
        return self::where('target', $target)->first();
    }
}

