<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsActivity;

class ProjectImage extends Model
{
    use HasFactory, LogsActivity;
    
    protected $logTitleField = 'title_english';
    
    protected $table = 'project_images';
    protected $guarded = [];
    
    /**
     * Relationship: Project Image belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    /**
     * Create new record
     */
    public function NewRecord(array $data)
    {
        return $this->create($data);
    }
    
    /**
     * Get all images for a specific project
     */
    public function list($projectId)
    {
        return DB::select(
            "SELECT id, CONCAT('/storage', image) AS src
            FROM project_images
            WHERE project_images.project_id = :project_id
            ORDER BY created_at DESC",
            ['project_id' => $projectId]
        );
    }
    
    /**
     * Get all gallery images
     */
    public function getGallery()
    {
        return $this->get();
    }
    
    /**
     * Find image by ID
     */
    public function find(int $id)
    {
        return $this->findOrFail($id);
    }
    
    /**
     * Update record
     */
    public function updateRecord(int $id, array $data)
    {
        $this->findOrFail($id)->update($data);
    }
    
    /**
     * Delete record
     */
    public function deleteRecord(int $id)
    {
        $this->findOrFail($id)->delete();
    }
    
    /**
     * Get all gallery IDs for a project
     */
    public function getGalleryIds($projectId)
    {
        return $this->where('project_id', $projectId)->pluck('id');
    }
    
    /**
     * Get project images by project ID
     */
    public function getProjectImages($projectId)
    {
        $images = DB::select('
            SELECT 
                project_images.id,
                project_images.image 
            FROM project_images
            WHERE project_images.project_id = :id
            ORDER BY project_images.created_at DESC',
            ['id' => $projectId]
        );
        return $images;
    }
    
    /**
     * Get all project images for listing
     */
    public function gallerylist()
    {
        $gallery = DB::select('
            SELECT 
                id,
                image,
                project_id
            FROM project_images
            ORDER BY created_at DESC
        ');
        return $gallery;
    }
}

