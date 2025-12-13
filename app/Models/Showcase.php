<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Showcase extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'showcases';
    protected $guarded = [];
    
    /**
     * Get all showcases for listing
     */
    public static function list()
    {
        return DB::table('showcases')
            ->select('id', 'title_english', 'title_arabic', 'status', 'home_status', 'main_image', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Get trashed showcases
     */
    public static function trashed()
    {
        return DB::table('showcases')
            ->select('id', 'title_english', 'title_arabic', 'status', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }
    
    /**
     * Create new record
     */
    public function newRecord(array $data)
    {
        return $this->create($data);
    }
    
    /**
     * Update record
     */
    public function updateRecord(int $id, array $data)
    {
        return $this->findOrFail($id)->update($data);
    }
    
    /**
     * Delete record (soft delete)
     */
    public function deleteRecord(int $id)
    {
        return $this->findOrFail($id)->delete();
    }
    
    /**
     * Get related services
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'showcase_service', 'showcase_id', 'service_id')
                    ->withTimestamps();
    }
    
    /**
     * Get related projects
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'showcase_project', 'showcase_id', 'project_id')
                    ->withTimestamps();
    }
    
    /**
     * Get related portfolios
     */
    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class, 'showcase_portfolio', 'showcase_id', 'portfolio_id')
                    ->withTimestamps();
    }
    
    /**
     * Get related team members
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'showcase_team', 'showcase_id', 'team_id')
                    ->withTimestamps();
    }
    
    /**
     * Get related news
     */
    public function news()
    {
        return $this->belongsToMany(News::class, 'showcase_new', 'showcase_id', 'new_id')
                    ->withTimestamps();
    }
}

