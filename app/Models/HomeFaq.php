<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class HomeFaq extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'home_faqs';
    protected $guarded = [];
    
    /**
     * Get all FAQs for listing
     */
    public static function list()
    {
        $faqs = DB::table('home_faqs')
            ->select(
                'id',
                'question_english as Question (EN)',
                'question_arabic as Question (AR)',
                'order as Order',
                DB::raw("CASE WHEN status = 0 THEN 'Active' ELSE 'Inactive' END as Status")
            )
            ->whereNull('deleted_at')
            ->orderBy('order', 'asc')
            ->get();
            
        return $faqs->map(function ($item) {
            return (array) $item;
        })->toArray();
    }
    
    /**
     * Get trashed FAQs
     */
    public static function trashed()
    {
        $faqs = DB::table('home_faqs')
            ->select(
                'id',
                'question_english as Question (EN)',
                'question_arabic as Question (AR)',
                'deleted_at as Deleted At'
            )
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
            
        return $faqs->map(function ($item) {
            return (array) $item;
        })->toArray();
    }
    
    /**
     * Get active FAQs for home page
     */
    public static function getHomeFaqs()
    {
        return self::where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('order', 'asc')
            ->get();
    }
}

