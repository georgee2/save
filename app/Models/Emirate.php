<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Emirate extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'emirates';
    protected $guarded = [];
    
    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-generate slug from English title if not provided
        static::creating(function ($emirate) {
            if (empty($emirate->slug)) {
                $emirate->slug = Str::slug($emirate->title_english);
            }
        });
        
        static::updating(function ($emirate) {
            if (empty($emirate->slug)) {
                $emirate->slug = Str::slug($emirate->title_english);
            }
        });
    }
    
    /**
     * Get all emirates for listing
     */
    public static function list()
    {
        return DB::table('emirates')
            ->select('id', 'title_english', 'title_arabic', 'bio_english', 'icon', 'image', 'slug', 'is_primary', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('is_primary', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get the primary emirate
     */
    public static function getPrimary()
    {
        return static::where('is_primary', true)
            ->whereNull('deleted_at')
            ->first();
    }
    
    /**
     * Set this emirate as primary (and unset others)
     */
    public function markAsPrimary()
    {
        // First, unset all other emirates as primary
        DB::table('emirates')
            ->where('is_primary', true)
            ->update(['is_primary' => false]);
        
        // Set this one as primary
        $this->is_primary = true;
        $this->save();
        
        return $this;
    }
    
    /**
     * Remove primary status from this emirate
     */
    public function unmarkAsPrimary()
    {
        $this->is_primary = false;
        $this->save();
        
        return $this;
    }
    
    /**
     * Get trashed emirates
     */
    public static function trashed()
    {
        return DB::table('emirates')
            ->select('id', 'title_english', 'title_arabic', 'slug', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find emirate by ID
     */
    public static function find($id)
    {
        return DB::table('emirates')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}

