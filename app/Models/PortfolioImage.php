<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PortfolioImage extends Model
{
    use HasFactory;
    
    protected $table = 'portfolio_images';
    protected $guarded = [];
    
    /**
     * Relationship: Portfolio Image belongs to Portfolio
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }
    
    /**
     * Create new record
     */
    public function NewRecord(array $data)
    {
        return $this->create($data);
    }
    
    /**
     * Get all images for a specific portfolio
     */
    public function list($portfolioId)
    {
        return DB::select(
            "SELECT id, CONCAT('/storage', image) AS src
            FROM portfolio_images
            WHERE portfolio_images.portfolio_id = :portfolio_id
            ORDER BY created_at DESC",
            ['portfolio_id' => $portfolioId]
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
     * Get all gallery IDs for a portfolio
     */
    public function getGalleryIds($portfolioId)
    {
        return $this->where('portfolio_id', $portfolioId)->pluck('id');
    }
    
    /**
     * Get portfolio images by portfolio ID
     */
    public function getPortfolioImages($portfolioId)
    {
        $images = DB::select('
            SELECT 
                portfolio_images.id,
                portfolio_images.image 
            FROM portfolio_images
            WHERE portfolio_images.portfolio_id = :id
            ORDER BY portfolio_images.created_at DESC',
            ['id' => $portfolioId]
        );
        return $images;
    }
    
    /**
     * Get all portfolio images for listing
     */
    public function gallerylist()
    {
        $gallery = DB::select('
            SELECT 
                id,
                image,
                portfolio_id
            FROM portfolio_images
            ORDER BY created_at DESC
        ');
        return $gallery;
    }
}

