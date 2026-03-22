<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Agent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'agents';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public static function list()
    {
        return DB::table('agents')
            ->join('users', 'agents.user_id', '=', 'users.id')
            ->join('job_titles', 'agents.job_title_id', '=', 'job_titles.id')
            ->join('ranks', 'agents.rank_id', '=', 'ranks.id')
            ->select(
                'agents.id',
                'agents.full_name_en',
                'agents.full_name_ar',
                'agents.status',
                'agents.created_at',
                'users.name as user_name',
                'users.email as user_email',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'ranks.name_english as rank_english',
                'ranks.name_arabic as rank_arabic'
            )
            ->whereNull('agents.deleted_at')
            ->orderBy('agents.created_at', 'desc')
            ->get();
    }

    public static function trashed()
    {
        return DB::table('agents')
            ->join('users', 'agents.user_id', '=', 'users.id')
            ->join('job_titles', 'agents.job_title_id', '=', 'job_titles.id')
            ->join('ranks', 'agents.rank_id', '=', 'ranks.id')
            ->select(
                'agents.id',
                'agents.full_name_en',
                'agents.full_name_ar',
                'agents.status',
                'agents.deleted_at',
                'users.name as user_name',
                'users.email as user_email',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'ranks.name_english as rank_english',
                'ranks.name_arabic as rank_arabic'
            )
            ->whereNotNull('agents.deleted_at')
            ->orderBy('agents.deleted_at', 'desc')
            ->get();
    }

    public static function findWithRelations($id)
    {
        return DB::table('agents')
            ->join('users', 'agents.user_id', '=', 'users.id')
            ->join('job_titles', 'agents.job_title_id', '=', 'job_titles.id')
            ->join('ranks', 'agents.rank_id', '=', 'ranks.id')
            ->select(
                'agents.*',
                'users.name as user_name',
                'users.email as user_email',
                'job_titles.name_english as job_title_english',
                'job_titles.name_arabic as job_title_arabic',
                'ranks.name_english as rank_english',
                'ranks.name_arabic as rank_arabic'
            )
            ->where('agents.id', $id)
            ->whereNull('agents.deleted_at')
            ->first();
    }
}
