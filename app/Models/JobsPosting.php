<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class JobsPosting extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'jobs_postings';
    protected $guarded = [];
    
    protected $casts = [
        'registration_start_date' => 'date',
        'registration_end_date' => 'date',
        'show_salary' => 'boolean',
    ];
    
    /**
     * Relationship: JobsPosting belongs to JobTitle
     */
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }
    
    /**
     * Relationship: JobsPosting belongs to JobCategory
     */
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }
    
    /**
     * Generate unique job code
     */
    public static function generateCode()
    {
        $prefix = 'JOB';
        $year = date('Y');
        $lastJob = self::whereYear('created_at', $year)
                      ->orderBy('id', 'desc')
                      ->first();
        
        if ($lastJob) {
            $lastNumber = (int) substr($lastJob->code, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return $prefix . $year . $newNumber;
    }
    
    /**
     * Get all jobs postings for listing
     */
    public static function list()
    {
        return DB::table('jobs_postings')
            ->leftJoin('job_titles', 'jobs_postings.job_title_id', '=', 'job_titles.id')
            ->leftJoin('job_categories', 'jobs_postings.job_category_id', '=', 'job_categories.id')
            ->select(
                'jobs_postings.*',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'job_categories.name_english as job_category_english',
                'job_categories.name_arabic as job_category_arabic'
            )
            ->whereNull('jobs_postings.deleted_at')
            ->orderBy('jobs_postings.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed jobs postings
     */
    public static function trashed()
    {
        return DB::table('jobs_postings')
            ->leftJoin('job_titles', 'jobs_postings.job_title_id', '=', 'job_titles.id')
            ->leftJoin('job_categories', 'jobs_postings.job_category_id', '=', 'job_categories.id')
            ->select(
                'jobs_postings.*',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'job_categories.name_english as job_category_english',
                'job_categories.name_arabic as job_category_arabic'
            )
            ->whereNotNull('jobs_postings.deleted_at')
            ->orderBy('jobs_postings.deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Find job posting by ID with relationships
     */
    public static function findWithRelations($id)
    {
        return DB::table('jobs_postings')
            ->leftJoin('job_titles', 'jobs_postings.job_title_id', '=', 'job_titles.id')
            ->leftJoin('job_categories', 'jobs_postings.job_category_id', '=', 'job_categories.id')
            ->select(
                'jobs_postings.*',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'job_categories.name_english as job_category_english',
                'job_categories.name_arabic as job_category_arabic'
            )
            ->where('jobs_postings.id', $id)
            ->whereNull('jobs_postings.deleted_at')
            ->first();
    }
}

