<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsActivity;

class Team extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $logTitleField = 'name_english';
    
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
                'teams.is_board_director',
                'teams.display_order',
                'teams.board_order',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'ranks.name_english as rank_english',
                'ranks.name_arabic as rank_arabic',
                'ranks.is_board_director as rank_is_board_director',
                'teams.created_at',
                'teams.updated_at'
            )
            ->whereNull('teams.deleted_at')
            ->orderBy('teams.created_at', 'desc')
            ->get();
    }
    
    /**
     * Get regular team members (non-board directors) ordered by display_order
     */
    public static function getRegularMembers()
    {
        return DB::table('teams')
            ->leftJoin('job_titles', 'teams.job_title_id', '=', 'job_titles.id')
            ->leftJoin('ranks', 'teams.rank_id', '=', 'ranks.id')
            ->select(
                'teams.id',
                'teams.name_english',
                'teams.name_arabic',
                'teams.main_image',
                'teams.icon',
                'teams.display_order',
                'job_titles.name_english as job_title_english',
                'ranks.name_english as rank_english'
            )
            ->where('teams.is_board_director', false)
            ->whereNull('teams.deleted_at')
            ->orderBy('teams.display_order', 'asc')
            ->get();
    }
    
    /**
     * Get board of directors members ordered by board_order
     */
    public static function getBoardMembers()
    {
        return DB::table('teams')
            ->leftJoin('job_titles', 'teams.job_title_id', '=', 'job_titles.id')
            ->leftJoin('ranks', 'teams.rank_id', '=', 'ranks.id')
            ->select(
                'teams.id',
                'teams.name_english',
                'teams.name_arabic',
                'teams.main_image',
                'teams.icon',
                'teams.board_order',
                'job_titles.name_english as job_title_english',
                'ranks.name_english as rank_english'
            )
            ->where('teams.is_board_director', true)
            ->whereNull('teams.deleted_at')
            ->orderBy('teams.board_order', 'asc')
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
                'teams.is_board_director',
                'job_titles.name_english as job_title_english',
                'ranks.name_english as rank_english',
                'teams.deleted_at'
            )
            ->whereNotNull('teams.deleted_at')
            ->orderBy('teams.deleted_at', 'desc')
            ->get();
    }
}

