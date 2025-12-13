<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'teams';
    protected $guarded = [];
    
    /**
     * Relationship: Team belongs to Job Title
     */
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }
    
    /**
     * Relationship: Team belongs to Rank
     */
    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id');
    }
    
    /**
     * Get all team members for listing
     */
    public static function list()
    {
        return DB::table('teams')
            ->leftJoin('job_titles', 'teams.job_title_id', '=', 'job_titles.id')
            ->leftJoin('ranks', 'teams.rank_id', '=', 'ranks.id')
            ->select(
                'teams.id',
                'teams.name_english',
                'teams.name_arabic',
                'teams.email',
                'teams.mobile',
                'teams.main_image',
                'teams.icon',
                'teams.page_image',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'ranks.name_english as rank_english',
                'ranks.name_arabic as rank_arabic',
                'teams.created_at',
                'teams.updated_at'
            )
            ->whereNull('teams.deleted_at')
            ->orderBy('teams.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed team members
     */
    public static function trashed()
    {
        return DB::table('teams')
            ->leftJoin('job_titles', 'teams.job_title_id', '=', 'job_titles.id')
            ->leftJoin('ranks', 'teams.rank_id', '=', 'ranks.id')
            ->select(
                'teams.id',
                'teams.name_english',
                'teams.name_arabic',
                'teams.email',
                'teams.mobile',
                'job_titles.name_english as job_title_english',
                'ranks.name_english as rank_english',
                'teams.deleted_at'
            )
            ->whereNotNull('teams.deleted_at')
            ->orderBy('teams.deleted_at', 'desc')
            ->get();
    }
}

