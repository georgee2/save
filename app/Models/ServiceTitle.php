<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ServiceTitle extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [];
    
    /**
     * Get all service titles for listing
     */
    public function list()
    {
        $titles = DB::select('
            SELECT 
                service_titles.id AS "Code",
                service_titles.title_english AS "English Title",
                service_titles.title_arabic AS "Arabic Title",
                service_titles.subtitle_english AS "English Subtitle",
                service_titles.subtitle_arabic AS "Arabic Subtitle",
                service_titles.target AS "Target Section"
            FROM service_titles
            WHERE service_titles.deleted_at IS NULL 
            ORDER BY service_titles.target ASC, service_titles.id ASC
        ');
        return $titles;
    }
    
    /**
     * Get trashed service titles
     */
    public function trashed()
    {
        $titles = DB::select('
            SELECT 
                service_titles.id AS "Code",
                service_titles.title_english AS "English Title",
                service_titles.title_arabic AS "Arabic Title",
                service_titles.subtitle_english AS "English Subtitle",
                service_titles.subtitle_arabic AS "Arabic Subtitle",
                service_titles.target AS "Target Section"
            FROM service_titles
            WHERE service_titles.deleted_at IS NOT NULL 
            ORDER BY service_titles.target ASC, service_titles.id ASC
        ');
        return $titles;
    }
    
    /**
     * Find a specific service title
     */
    public function find(int $id)
    {
        $title = DB::select('
            SELECT service_titles.*
            FROM service_titles 
            WHERE service_titles.id = :id
        ', ['id' => $id]);
        
        return collect($title)->first();
    }
    
    /**
     * Create new record
     */
    public function NewRecord(array $data)
    {
        $this->create($data);
    }
    
    /**
     * Update record
     */
    public function updateRecord(int $id, array $data)
    {
        $this->findOrFail($id)->update($data);
    }
    
    /**
     * Delete record (soft delete)
     */
    public function deleteRecord(int $id)
    {
        $this->findOrFail($id)->delete();
    }
    
    /**
     * Restore soft deleted record
     */
    public function restore(int $id)
    {
        $title = ServiceTitle::withTrashed()->where('id', $id)->restore();
        return $title;
    }
    
    /**
     * Get title by target section
     */
    public static function getByTarget(string $target)
    {
        return self::where('target', $target)
                   ->whereNull('deleted_at')
                   ->first();
    }
}
