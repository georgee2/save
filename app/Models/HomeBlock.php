<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class HomeBlock extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'home_blocks';
    protected $guarded = [];
    
    /**
     * Get all home blocks for listing
     */
    public static function list()
    {
        return DB::table('home_blocks')
            ->select(
                'id',
                'title_english',
                'title_arabic',
                'subtitle_english',
                'subtitle_arabic',
                'button_text_english',
                'button_text_arabic',
                'url_english',
                'url_arabic',
                'location',
                'status',
                'created_at',
                'updated_at'
            )
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed home blocks
     */
    public static function trashed()
    {
        return DB::table('home_blocks')
            ->select(
                'id',
                'title_english',
                'title_arabic',
                'location',
                'status',
                'deleted_at'
            )
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Get location display name
     */
    public function getLocationDisplayAttribute()
    {
        $locations = [
            'about_section' => 'About Section',
            'why_choose_us' => 'Why Choose Us'
        ];
        
        return $locations[$this->location] ?? $this->location;
    }
    
    /**
     * Get status display name
     */
    public function getStatusDisplayAttribute()
    {
        return $this->status == 0 ? 'Active' : 'Not Active';
    }
}

