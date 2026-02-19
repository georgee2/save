<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsActivity;

class OfferImage extends Model
{
    use HasFactory, LogsActivity;
    
    protected $logTitleField = 'title_english';
    
    protected $table = 'offer_images';
    protected $guarded = [];
    
    /**
     * Relationship: Offer Image belongs to Offer
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
    
    /**
     * Create new record
     */
    public function NewRecord(array $data)
    {
        return $this->create($data);
    }
    
    /**
     * Get all images for a specific offer
     */
    public function list($offerId)
    {
        return DB::select(
            "SELECT id, CONCAT('/storage', image) AS src
            FROM offer_images
            WHERE offer_images.offer_id = :offer_id
            ORDER BY created_at DESC",
            ['offer_id' => $offerId]
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
     * Get all gallery IDs for an offer
     */
    public function getGalleryIds($offerId)
    {
        return $this->where('offer_id', $offerId)->pluck('id');
    }
    
    /**
     * Get offer images by offer ID
     */
    public function getOfferImages($offerId)
    {
        $images = DB::select('
            SELECT 
                offer_images.id,
                offer_images.image 
            FROM offer_images
            WHERE offer_images.offer_id = :id
            ORDER BY offer_images.created_at DESC',
            ['id' => $offerId]
        );
        return $images;
    }
    
    /**
     * Get all offer images for listing
     */
    public function gallerylist()
    {
        $gallery = DB::select('
            SELECT 
                id,
                image,
                offer_id
            FROM offer_images
            ORDER BY created_at DESC
        ');
        return $gallery;
    }
}

