<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsActivity;

class Certificate extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $logTitleField = 'name_english';
    
    protected $table = 'certificates';
    protected $guarded = [];
    
    /**
     * Get all certificates for listing
     */
    public static function list()
    {
        return DB::table('certificates')
            ->select('id', 'name_english', 'name_arabic', 'image', 'bio_english', 'bio_arabic', 'ordering', 'publish_status', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed certificates
     */
    public static function trashed()
    {
        return DB::table('certificates')
            ->select('id', 'name_english', 'name_arabic', 'image', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Get published certificates ordered
     */
    public static function getPublished()
    {
        return self::where('publish_status', 1)
            ->orderBy('ordering', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get max ordering value
     */
    public static function getMaxOrdering()
    {
        return self::whereNull('deleted_at')->max('ordering') ?? 0;
    }
}
