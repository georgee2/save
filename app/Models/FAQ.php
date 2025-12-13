<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FAQ extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'faqs';
    protected $guarded = [];
    
    /**
     * Get all FAQs for listing
     */
    public static function list()
    {
        return DB::table('faqs')
            ->select('id', 'question_english', 'question_arabic', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed FAQs
     */
    public static function trashed()
    {
        return DB::table('faqs')
            ->select('id', 'question_english', 'question_arabic', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find FAQ by ID
     */
    public static function find($id)
    {
        return DB::table('faqs')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}
